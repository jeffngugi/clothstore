<?php

namespace App\Http\Controllers;

use App\Models\User;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIController;

class AuthController extends APIController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
      */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'register']]);
    // }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $email =  $request->email;
        $user = User::where('email', $email)->first();
       if(!$user){
           return $this->responseNotFound('User not found');
       }
        //TO DO//see if the user email is verified
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            //TO DO: Check if email is verified
            return $this->respondWithToken($token);
        }
        return $this->responseUnauthorized();
    }



    public function register(Request $request){
       
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
            //check if validator passess
        if($validator->fails()){
            return $this->responseUnprocessable($validator->errors());
        }
        //append verification code to cod
        $verification_code = sha1(time());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'verification_code' =>  $verification_code,
        ]);
            
        if($user){
            $email= $request->email;
            $name=$request->name;

            // To do: Send verifiction email;
            // //Make mail function for the code below
            // $subject = 'Please verify your email address';
    	    // Mail::send('email.verify', ['name'=>$name,'verification_code'=>$verification_code],
    		// function($mail) use ($email,$name,$subject){
    		// 	$mail->from('sutralian@gmail.com','test verify');
    		// 	$mail->to($email,$name);
    		// 	$mail->subject($subject);
    		// });
            return response()->json(['status' => 'User created successfully'], 201);
           
        }else{
            //ask users to retry
            return $this->responseUnauthorized('User could not be created');
        }

        if(!$token = auth()->attempt($request->only(['email', 'password'])))
        {
            return $this->responseUnauthorized();
        }

    }

    public function emailVerify(){
        return response()->json(['status', 'email verification logics']);
    }
    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        if($this->guard()->user()){
        return response()->json($this->guard()->user()->only(['id','name', 'email']));
        }else{
            return $this->responseUnauthorized();
        }
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function closed(){
        $this->responseSuccess('Closed');
    }

    public function jeff(){
        return $this->responseSuccess('Jeff');
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
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
            'status' => 200,
            'message'=>'Authorized',
            'access_token' =>'Bearer ' . $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}