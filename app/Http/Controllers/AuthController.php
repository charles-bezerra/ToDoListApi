<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\User;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance and set your middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api',
            [ 'except' => ['login','register'] ]
        );
    }

    /**
     * Login of the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        if (! ($token = $this->guard()->attempt([ 'email' => $email, 'password' => $password ])) )
            return response()
                ->json([
                    'success' => false,
                    'error' => 'Email ou senha estão incorretos.'
                ]);

        return $this->respondWithToken($token);
    }

    /**
     * Register of the new user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        $request->validate([
            'name' => 'required|unique:tasks|max:150',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->password = Hash::make( $request->input('password') );

        try{
            $user->save();
            return $this->login($request);
        }
        catch( QueryException $e ){
            return response()->json([
                'success' => false,
                'error' => 'Email já registrado'
            ]);
        }
        catch( Exception $e ) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        };
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()
                    ->json([
                        'success'=>true,
                        'message' => 'Successfully logged out'
                    ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken( $this->guard()->refresh() );
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return response()->json( $this->guard()->user() );
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
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    private function guard() {
        return Auth::guard();
    }
}
