<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificationEmail;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel API Documentation",
 *      description="API endpoints for authentication",
 *      @OA\Contact(
 *          email="support@example.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     description="Creates a new user account and sends a verification email.",
     *     operationId="register",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name","last_name","email","password","password_confirmation"},
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
     *             @OA\Property(property="phone", type="string", example="+84123456789"),
     *             @OA\Property(property="address", type="string", example="123 Street, City"),
     *             @OA\Property(property="date_of_birth", type="string", format="date", example="2000-01-01"),
     *             @OA\Property(property="gender", type="string", enum={"male","female","other"}, example="male")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registration successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Registration successful! Please check your email for verification."),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|in:male,female,other',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $userData = [
                'first_name' => trim($request->first_name),
                'last_name' => trim($request->last_name),
                'email' => trim($request->email),
                'password' => Hash::make($request->password),
                'verification_token' => Str::random(64),
                'role' => 'customer',
                'phone' => $request->phone,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'is_active' => true
            ];

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->storeAs('public/avatars', $filename);
                $userData['avatar'] = 'avatars/' . $filename;
            }

            $user = User::create($userData);

            try {
                Mail::to($user->email)->send(new VerificationEmail($user));
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Registration successful but verification email could not be sent.',
                    'user' => $user,
                    'error' => 'Email sending failed'
                ], 201);
            }

            return response()->json([
                'message' => 'Registration successful! Please check your email for verification.',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/verify-email/{token}",
     *     summary="Verify user email",
     *     description="Verify the user's email using the provided token.",
     *     operationId="verifyEmail",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         required=true,
     *         description="Verification token",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email verified successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email verified successfully")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Invalid verification token")
     * )
     */
    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification token'], 404);
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        return response()->json(['message' => 'Email verified successfully']);
    }
}