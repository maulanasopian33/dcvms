<?php

namespace App\Http\Controllers;

use App\Models\teams;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        return response()->json([
            'datas' => teams::where('lead_id',$id)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = teams::create([
                'UID' => $request->UID,
                'lead_id' => $request->lead_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'nik' => $request->nik,
                'ktp' => $request->ktp,
            ]);
            return response()->json([
                "status" => true,
                "message"   => "Berhasil di tambahkan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status"    => true,
                "message"   => "Gagal di update",
                "error"     => $th
            ]);
        }

        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function getbyname($id,$data)
    {
        return response()->json([
            'datas' => teams::whereIn('name',json_decode(urldecode($data)))->where('lead_id',$id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $team = teams::findOrFail($request->UID);
            $team->update([
                'UID' => $request->UID,
                'lead_id' => $request->lead_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'nik' => $request->nik,
                'ktp' => $request->ktp,
            ]);
            return response()->json([
                "status"    => true,
                "message"   => "Berhasil di update"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status"    => true,
                "message"   => "Gagal di update",
                "error"     => $th
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uid)
    {
        try {
            $data = teams::findOrFail($uid);
            $data->delete();
            return response()->json([
                "status" => true,
                "message"=> "Berhasil Menghapus Data Teams "

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message"=> "Gagal Menghapus",
                "error"=> $th

            ]);
        }
    }
}
