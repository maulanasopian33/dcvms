<?php

namespace App\Http\Controllers;

use App\Models\visit_dc;
use App\Http\Controllers\Controller;
use App\Mail\notifMail;
use App\Models\product;
use App\Models\productdetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VisitDcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        return response()->json([
            'datas' => visit_dc::with('users')->where('id_user',$id)->get()
        ]);
    }

    public function getall(Request $req){

        return response()->json([
            "status"    => true,
            "message"   => "berhasil",
            "data"      => visit_dc::orderBy('created_at',"DESC")->get()

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $server = explode('/',$request->serverId)[0];
        try {
            switch ($request->reason) {
                case 'Installation':
                    foreach ($request->dataserver as $key => $value) {
                        $railkit = false;
                        if($value['railkit'] === 'Tersedia'){ $railkit = true;}
                        $produk = [
                            'productId'     => $server,
                            'merek'         => $value['merek'],
                            'jenis_server'  => $value['category'],
                            'SN'            => $value['sn'],
                            'ukuran'        => $value['ukuran'],
                            'psu'           => $value['psu'],
                            'railkit'       => $railkit,
                            'visit_id'      => $request->UID,
                            'datacenter'    => $request->data_center,
                        ];
                        $produkdetail = productdetail::create($produk);
                    }
                    break;

                default:
                    # code...
                    break;
            }
            $req = [
                'UID'             => $request->UID,
                'id_user'         => $request->id_user,
                'lead_name'       => $request->lead_name,
                'lead_email'      => $request->lead_email,
                'lead_phone'      => $request->lead_phone,
                'lead_nik'        => $request->lead_nik,
                'lead_ktp'        => $request->lead_ktp,
                'lead_signature'  => $request->lead_signature,
                'company_name'    => $request->company_name,
                'Date'            => $request->Date,
                'data_center'     => $request->data_center,
                'reason'          => $request->reason,
                'teams'           => $request->teams,
                'file_surat'         => $request->file_surat,
                'server_maintenance' => $request->server_maintenance,
                'productId'        => $server
            ];
            $data = visit_dc::create($req);
            $update = User::findOrFail($request->id_user);
            $update->update([
                'ktp'       => $request->lead_ktp,
                'nik'       => $request->lead_nik,
                'id_user'   => $update->id_user,
                'name'      => $update->name,
                'email'     => $update->email,
            ]);
            $mailData = [
                'subject'       => "Request DC - ".$request->lead_name . ' ' . $request->data_center,
                'tanggal'       => $request->Date,
                'dc'            => $request->data_center,
                'nama'          => $request->lead_name,
                'email'         => $request->lead_email,
                'perusahaan'    => $request->company_name,
                'keperluan'     => $request->reason,
                'from'          => $request->lead_email,
                'url'           => env("FE_URL").'requestdc/report/'.base64_encode($request->UID)
            ];
            Mail::to("maulana@antmediahost.com")->send(new notifMail($mailData));
            return response()->json([
                "status" => true,
                "message"=> "Berhasil Menambahkan Data Visit "

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message"=> "Gagal Menambahkan Data Visit ",
                "data"   => $th->getMessage()
            ]);
        }
    }
    public function guestrequest(Request $request)
    {
        try {
            $req = [
                'UID'             => $request->UID,
                'lead_email'      => $request->email,
                'lead_phone'      => $request->phone,
                'lead_nik'        => $request->nik,
                'lead_ktp'        => $request->ktp,
                'lead_signature'  => $request->name,
                'company_name'    => $request->company_name,
                'Date'            => $request->Date,
                'data_center'        => $request->data_center,
                'reason'             => "visit DC",
                'teams'              => $request->teams,
                'file_surat'         => "",
                'server_maintenance' => "visit DC",
            ];
            $data = visit_dc::create($req);
            $mailData = [
                'subject'       => "Request Visit DC - " . $request->data_center,
                'tanggal'       => $request->Date,
                'dc'            => $request->data_center,
                'nama'          => $request->name,
                'email'         => $request->email,
                'perusahaan'    => $request->company_name,
                'keperluan'     => $request->reason,
                'from'          => $request->email,
                'url'           => env("FE_URL").'requestdc/report/'.base64_encode($request->UID)
            ];
            Mail::to("maulana@antmediahost.com")->send(new notifMail($mailData));
            return response()->json([
                "status" => true,
                "message"=> "Berhasil Menambahkan Data Visit "

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message"=> "Gagal Menambahkan Data Visit ",
                "data"   => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getbyUID($uid)
    {
        $data = visit_dc::with('users')->where('UID',$uid)->get();
        $temp = [];
        foreach (explode(',',$data[0]->productId) as $key => $value) {
            array_push($temp,product::with('productdetail')->find($value));
        }
        $data[0]['product'] = $temp;
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req)
    {
        try {

            $data = visit_dc::findOrFail($req->uid);
            $data->update([
                "success" => $req->success
            ]);
            return response()->json([
                "status" => true,
                "message"=> "Berhasil Mengupdate Status Data Visit ".$data->name

            ]);
     } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
            "status" => false,
            "message"=> "Gagal mengupdate data",
            "error"=> $th

        ]);
     }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uid)
    {
        try {
            $data = visit_dc::findOrFail($uid);
            $dataTemp = $data;
            $data->delete();
            return response()->json([
                "status" => true,
                "message"=> "Berhasil Menghapus Data Visit ".$dataTemp->name

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message"=> "Gagal menghapus data",
                "error"=> $th

            ]);
        }
    }
}
