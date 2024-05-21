<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Inertia\Inertia;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','showRegistrationForm','showLoginForm']]);
    }
     /**
    * Show the registration form.
    *
    * @return \Inertia\Response
    */
   public function showRegistrationForm()
   {
       return Inertia::render('Register');
   }

   public function showLoginForm()
   {
    if (auth()->check()) {
        // If authenticated, redirect to home page
        return redirect()->route('login');
    }
       return Inertia::render('Login');
   }
 /**
     * Get a JWT via given credentials.
     *
     * @return \Inertia\Response|\Illuminate\Http\JsonResponse
     */

     public function login(Request $request)
     {
         $credentials = $request->only('email', 'password');
 
         if (!$token = JWTAuth::attempt($credentials)) {
             return response()->json(['error' => 'Unauthorized'], 401);
         }
       
         return Inertia::render('Home', [
             'token' => $token,
             'token_type' => 'bearer',
             'expires_in' => auth()->factory()->getTTL() * 60
         ]);
     }
 

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        

    // Clear the token from the client-side
    $forever = true;
    JWTAuth::parseToken()->invalidate( $forever );
  
    return Inertia::render('Home', [
        'success' => 'true',
        
    ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|max:255',
        ]);
        
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('home')->with('success', 'User registered successfully.');
    }

}