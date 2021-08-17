<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class MasyarakatController extends Controller
{
    public $response;
    public function __construct() {
        $this->response = new ResponHelper();
    }

    public function get()
    {
        $data["count"] = User::where('level','=','masyarakat')->count();

        return $this->response->successData($data);
    }

    public function getAll($limit = NULL, $offset = NULL)
    {
        $data["count"] = User::where('level','=','masyarakat')->count();
        
        if($limit == NULL && $offset == NULL){
            $data["user"] = User::where('level','=','masyarakat')->get();
        } else {
            $data["user"] = User::where('level','=','masyarakat')->take($limit)->skip($offset)->get();
        }

        return $this->response->successData($data);
    }

    public function getById($id)
    {
        $data["pengaduan"] = User::where('level','=','masyarakat')->get();
        return $this->response->successData($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
			'nik' => 'required|string|max:16',
			'nama' => 'required|string|max:32',
			'password' => 'required|string|min:6',
			'telp' => 'required|string|min:10',
		]);

		if($validator->fails()){
            return $this->response->errorResponse($validator->errors());
		}

		$user = User::where('id', $id)->first();
		$user->nama 	= $request->nama;
        $user->password = Hash::make($request->password);
		$user->telp 	= $request->telp;
		$user->save();

        return $this->response->successResponse('Data masyarakat berhasil diubah');
    }

    public function delete($id)
    {
        $delete = User::where('id', $id)->delete();

        if($delete){
            return $this->response->successResponse('Data masyarakat berhasil dihapus');
        } else {
            return $this->response->errorResponse('Data masyarakat gagal dihapus');
        }
    }
}
