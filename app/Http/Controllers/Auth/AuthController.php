<?php

namespace App\Http\Controllers\Auth;

use App\User;
//use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    //use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    // /**
    //  * Create a new authentication controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest', ['except' => 'getLogout']);
    // }

    public function authenticate(Request $request){
      $credentials = $request->only('email', 'password');

      try{
        if(! $token = JWTAuth::attempt($credentials)){
          return $this->response->errorUnauthorized();
        }
      } catch( JWTException $ex){
        return $this->response->errorInternal();
      }

      return $this->response->array(compact('token'))->setStatusCode(200);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    // Get all users
    public function index(){
      return User::all();
    }

    // Get user based on toke
    public function show(){
      try{
        $user = JWTAuth::parseToken()->toUser();
        if(!$user){
          return $this->response->errorNotFound('User not found');
        }
      } catch (JWTException $ex){
          return $this->response->error('Something went wrong');
      }

      return $this->response->array(compact('user'))->setStatusCode(200);
    }

    // Refresh token and return it to client.
    public function getToken(){
      $token = JWTAuth::getToken();

      if(!$token){
        return $this->response->errorUnauthorized("Token is invalid");
      }

      try{
        $refreshedToken = JWTAuth::refresh($token);
      } catch(JWTException $ex){
        $this->response->error('Something went wrong');
      }
      return $this->response->array(compact('refreshedToken'));
    }

    public function destroy(){
      $user = JWTAuth::parseToken()->authenticate();
      if(!user){
        return $this->response->errorUnauthorized("Unauthorized process");
      }

      $user->delete();
    }

}
