<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @return JsonResponse
     */
    public function register(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);

        // assign role to user
        $user->assignRole('user');

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    /**
     * Authenticate a user and generate a JWT token.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // get role and  permissions of each role of user
        $user = auth()->user();
        // $user->role = $user->getRoleNames();
        $user->permissions = $user->getAllPermissions();



        return response()->json(['token' => $token,"user"=>$user]);
    }

    /**
     * Get the authenticated user.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(['user' => auth()->user()]);
    }

    /**
     * Logout the authenticated user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh the JWT token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $newToken = auth()->refresh();

        return response()->json(['token' => $newToken]);
    }
      /**
     * Update the authenticated user's account.
     *
     * @return JsonResponse
     */
    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:users,email,' . auth()->id() . '|max:255',
            'password' => 'sometimes|required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = auth()->user();
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email') && $request->input('email') !== $user->email) {
            $user->email = $request->input('email');
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }


    public function updatePassword(Request $request, $token){
        // return $token;
        $user = User::where('reset_password_token', $token)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
        $request->validate([
            'password' => 'required|string|min:6',
        ]);
        $user->password = Hash::make($request->password);
        $user->reset_password_token = null;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully',
        ]);

    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        // Generate a unique token and store it in the user's database record.
        $token = Str::random(60);
        $user->reset_password_token = $token;
        $user->save();

        // Create an email with a link to a password reset page that includes the unique token in the URL.
        $resetLink = url('/api/password-reset/'.$token);

        // Send the email to the user's email address using a library like Laravel's built-in Mail class.
        Mail::to($user->email)->send(new ForgotPasswordMail($resetLink));

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset email sent',
        ]);
    }

}
