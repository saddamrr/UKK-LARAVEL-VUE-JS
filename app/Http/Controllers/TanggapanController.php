<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponHelper;
use Illuminate\Support\Facades\Validator;
use App\Models\Tanggapan;
use JWTAuth;

class TanggapanController extends Controller
{
    public $response;
    public $user;
    public function __construct(){
        $this->response = new ResponHelper();
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pengaduan' => 'required',
            'tanggapan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        $tanggapan = Tanggapan::where('id_pengaduan', $request->id_pengaduan)->first();
        if ($tanggapan == NULL) {
            $tanggapan  = new Tanggapan();
        }

        $tanggapan->id_pengaduan = $request->id_pengaduan;
        $tanggapan->tgl_tanggapan = date('Y-m-d');
        $tanggapan->tanggapan = $request->tanggapan;
        $tanggapan->id_petugas = $this->user->id;
        $tanggapan->save();

        return $this->response->successResponse('Tanggapan berhasil dikirim!!!');
    }
}
