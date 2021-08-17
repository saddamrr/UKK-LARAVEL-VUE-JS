<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Pengaduan;
use JWTAuth;
use DB;

class PengaduanController extends Controller
{
    public $response;
    public $user;
    public function __construct() {
        $this->response = new ResponHelper();
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'isi_laporan' => 'required|string',
			'foto' => 'required'
		]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
		}

        $pengaduan = new Pengaduan();
		$pengaduan->tgl_pengaduan = date('Y-m-d');
		$pengaduan->id_user 	= $this->user->id;
		$pengaduan->isi_laporan = $request->isi_laporan;
		$pengaduan->foto 	= $request->foto;
		$pengaduan->status 	= '0';
		$pengaduan->save();

        return $this->response->successResponse('Berhasil mengirimkan pengaduan!');
    }

    public function getAllPengaduan($limit = NULL, $offset = NULL)
    {
        if($this->user->level == 'masyarakat'){
            $data["count"] = Pengaduan::where('id_user', '=', $this->user->id)->count();

            if($limit == NULL && $offset == NULL){
                $data["pengaduan"] = Pengaduan::where('id_user', '=', $this->user->id)->orderBy('tgl_pengaduan', 'desc')->get();
            } else {
                $data["pengaduan"] = Pengaduan::where('id_user', '=', $this->user->id)->orderBy('tgl_pengaduan', 'desc')->take($limit)->skip($offset)->get();
            }
        } else {
            $data["count"] = Pengaduan::count();

            if($limit == NULL && $offset == NULL){
                $data["pengaduan"] = Pengaduan::orderBy('tgl_pengaduan', 'desc')->get();
            } else {
                $data["pengaduan"] = Pengaduan::orderBy('tgl_pengaduan', 'desc')->take($limit)->skip($offset)->get();
            }
        }

        return $this->response->successData($data);
    }

    public function getById($id)
    {   
        $data["pengaduan"] = Pengaduan::where('id_pengaduan', $id)->with(['tanggapan'])->get();

        return $this->response->successData($data);
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'id_pengaduan' => 'required',
			'status' => 'required|string',
		]);

		if($validator->fails()){
            return $this->response->errorResponse($validator->errors());
		}

		$pengaduan          = Pengaduan::where('id_pengaduan', $request->id_pengaduan)->first();
		$pengaduan->status  = $request->status;
		$pengaduan->save();

        return $this->response->successResponse('Status berhasil diubah');
    }

    public function report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|numeric',
        ]);

        if($validator->fails()){
            return $this->response->errorResponse($validator->errors());
		}

        $query = DB::table('pengaduan')
                    ->select('pengaduan.tgl_pengaduan', 'pengaduan.isi_laporan', 'pengaduan.status', 'users.nama') //select yang ingin ditampilkan
                    ->join('users', 'users.id', '=', 'pengaduan.id_user') // join tabel user untuk mendapatkan nama petugas
                    ->whereYear('pengaduan.tgl_pengaduan', '=', $request->tahun);

        if($request->bulan != NULL){
            $query->WhereMonth('pengaduan.tgl_pengaduan', '=', $request->bulan);
        }
        if($request->tgl != NULL){
            $query->WhereDay('pengaduan.tgl_pengaduan', '=', $request->tgl);
        }

        $data = $query->get();

        return $this->response->successData($data);

        ModelTanggapan::select('pengaduan.id_pengaduan','pengaduan.isi_laporan','pengaduan.foto','tanggapan.tanggapan','petugas.nama_petugas','pengaduan.tgl_pengaduan','tanggapan.tgl_tanggapan')
                        ->join('petugas','petugas.id_petugas','=','tanggapan.id_petugas')
                        ->join('pengaduan','pengaduan.id_pengaduan','=','tanggapan.id_tanggapan')->get();
    }
}
