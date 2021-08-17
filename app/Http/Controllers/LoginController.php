<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public $response;
    public function __construct(){
        $this->response = new ResponHelper();
    }
    public function login(Request $request)
    {
		$credentials = $request->only('username', 'password');

		try {
			if(!$token = JWTAuth::attempt($credentials)){
                return $this->response->errorResponse('Invalid username and password');
			}
		} catch(JWTException $e){
            return $this->response->errorResponse('Generate Token Failed');
		}

        $data = [
            'token' => $token,
            'user' => JWTAuth::user()
        ];
        return $this->response->successResponseData('Authentication success', $data);
	}

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'nik' => 'required|string|max:16',
			'nama' => 'required|string|max:32',
			'username' => 'required|string|max:50',
			'password' => 'required|string|min:6',
			'telp' => 'required|string|min:10',
		]);

        if($validator->fails()){
            return $this->response->errorResponse($validator->errors());
		}

        $user = new User();
		$user->nik 	= $request->nik;
		$user->nama 	= $request->nama;
		$user->username = $request->username;
        $user->password = Hash::make($request->password);
		$user->telp 	= $request->telp;
		$user->level 	= 'masyarakat';
		$user->save();

        $token = JWTAuth::fromUser($user);

        $data = User::where('username', '=', $request->username)->first();
        return $this->response->successResponseData('Berhasil mendaftar sebagai masyarakat', $data);
    }

    public function loginCek(){
		try {
			if(!$user = JWTAuth::parseToken()->authenticate()){
				return $this->response->errorResponse('Invalid token!');
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
			return $this->response->errorResponse('Token expired!');
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
			return $this->response->errorResponse('Invalid token!');
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e){
			return $this->response->errorResponse('Token absent!');
		}

		return $this->response->successResponseData('Authentication success!', $user);
	}

    public function logout(Request $request)
    {
        if(JWTAuth::invalidate(JWTAuth::getToken())) {
            return $this->response->successResponse('You are logged out');
        } else {
            return $this->response->errorResponse('Logged out failed');
        }
    }
}
