<?php

namespace App\Http\Controllers;

use App\Models\visit_dc;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VisitDcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        return response()->json([
            'datas' => visit_dc::where('id_user',$id)->get()
        ]);
    }

    public function getall(){
        return response()->json([
            "status"    => true,
            "message"   => "berhasil",
            "data"      => visit_dc::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
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
                'webcam'          => $request->webcam
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
            return response()->json([
                "status" => true,
                "message"=> "Berhasil Menambahkan Data Visit "

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message"=> "Gagal menghapus data",
                "error"=> $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getbyUID($uid)
    {
        return response()->json([
            'datas' => visit_dc::where('UID',$uid)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, visit_dc $visit_dc)
    {
        //
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
