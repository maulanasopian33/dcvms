<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\surat;
use App\Models\visit_dc;
use Carbon\Carbon;
use chillerlan\QRCode\QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    public function update(Request $req){
        if (filter_var($req->client_signature, FILTER_VALIDATE_URL)) {
            $ttd_client = explode("storage/",$req->client_signature)[1];
        } else {
            $ttd_client = self::savefile($req->client_signature,'ttd/','ttd-client-');
        }
        if (filter_var($req->tim_signature, FILTER_VALIDATE_URL)) {
            $ttd_team = explode("storage/",$req->tim_signature)[1];
        } else {
            $ttd_team   = self::savefile($req->tim_signature,'ttd/','ttd-team-');
        }
        $ktp = [];
        foreach ($req->ktp as $key => $value) {
            array_push($ktp, explode("storage/",$value['img'])[1]);
        }
        $dokumentasi = [];
        foreach ($req->dokumentasi as $key => $value) {
            if (filter_var($value['data'], FILTER_VALIDATE_URL)) {
                array_push($dokumentasi, explode("storage/",$value['data'])[1]);
            } else {
                array_push($dokumentasi, self::savefile($value['data'],'dokumentasi/','dokumentasi-'));
            }
        }
        $support = admin::where('id', $req->supportID)->get();

        $postdata = [
            'fullname'          => $req->name,
            'email'             => $req->email,
            'phone_number'      => $req->phone,
            'nik'               => $req->nik,
            'ktp'               => json_encode($ktp),
            'address'           => $req->address,
            'position'          => $req->position,
            'company_name'      => $req->company,
            'company_npwp'      => $req->npwp,
            'company_address'   => $req->address2,
            'no_surat'          => $req->nosurat,
            'data_center'       => $req->data_center,
            'no_rack'           => $req->rack,
            'switch'            => $req->switch,
            'port'              => $req->port,
            'service'           => 'Colocation',
            'waktu_layanan'     => '',
            'os'                => $req->os,
            'arsitektur'        => $req->arsitektur,
            'control_panel'     => $req->controlPanel,
            'servers'           => '',
            'support_signature' => $ttd_team,
            'support_name'      => $support[0]->fullname,
            'support_email'     => $support[0]->email,
            'client_signature'  => $ttd_client,
            'dokumentasi'       => json_encode($dokumentasi),
            'productId'         => $req->productId,
            'uuid_visitdc'      => $req->uid
        ];
        $in = surat::find($req->id)->update($postdata);
        return response()->json([
            "status" => true,
            "message"=> "Berhasil Mengupdate Surat",
            "data"   => $in

        ]);
    }
    public function create(Request $req){
        $ttd_client = self::savefile($req->client_signature,'ttd/','ttd-client-');
        $ttd_team   = self::savefile($req->tim_signature,'ttd/','ttd-team-');
        $ktp = [];
        foreach ($req->ktp as $key => $value) {
            array_push($ktp, self::savefile($value['img'],'ktp/','ktp-'));
        }
        $dokumentasi = [];
        foreach ($req->dokumentasi as $key => $value) {
            array_push($dokumentasi, self::savefile($value['data'],'dokumentasi/','dokumentasi-'));
        }

        $support = admin::where('id', $req->supportID)->get();


        $postdata = [
            'fullname'          => $req->name,
            'email'             => $req->email,
            'phone_number'      => $req->phone,
            'nik'               => $req->nik,
            'ktp'               => json_encode($ktp),
            'address'           => $req->address,
            'position'          => $req->position,
            'company_name'      => $req->company,
            'company_npwp'      => $req->npwp,
            'company_address'   => $req->address2,
            'no_surat'          => $req->nosurat,
            'data_center'       => $req->data_center,
            'no_rack'           => $req->rack,
            'switch'            => $req->switch,
            'port'              => $req->port,
            'service'           => 'Colocation',
            'waktu_layanan'     => '',
            'os'                => $req->os,
            'arsitektur'        => $req->arsitektur,
            'control_panel'     => $req->controlPanel,
            'servers'           => '',
            'support_signature' => $ttd_team,
            'support_name'      => $support[0]->fullname,
            'support_email'     => $support[0]->email,
            'client_signature'  => $ttd_client,
            'dokumentasi'       => json_encode($dokumentasi),
            'productId'         => $req->productId,
            'uuid_visitdc'      => $req->uid
        ];
        $in = surat::create($postdata);
        return response()->json([
            "status" => true,
            "message"=> "Berhasil Menyimpan Surat",
            "data"   => $in

        ]);
    }
    public function savefile($file, $path, $name){
        if (!Str::contains($file,';base64,')) {
            return response()->json([
                'status' => false,
                'message'=> 'gagal membaca file'
            ]);
        }
        $base64ImageParts = explode(";base64,", $file);
        $imageType = explode("image/", $base64ImageParts[0])[1]; // Dapatkan jenis gambar
        $filename = $name.time().'.'.$imageType;
        $imageData = base64_decode($base64ImageParts[1]);
        Storage::put('public/'.$path.$filename,$imageData);
        return $path.$filename;
    }
    public function suratmasuk($id){
        $key = base64_decode(urldecode($id));
        $surat = surat::with('product.productdetail')->where('no_surat',$key)->get();

        if(count($surat) == 0){
            return response()->json([
                "status" => false,
                "message"=> "Data Surat tidak ditemukan ",
                "data"   => ''
            ]);
        }
        // Membuat objek mPDF
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);

        // Menambahkan konten ke mPDF
        $filename = 'Installation '.$surat[0]->company_name.'-'.Carbon::now()->isoFormat('D-M-Y');
        $mpdf->SetTitle($filename);
        // $mpdf->AddFont('arial', '', resource_path('font/arial.ttf'));
        // $mpdf->SetFont('arial');
        $mpdf->SetWatermarkImage(storage_path('app/public/bg.png')); // Ganti dengan path ke gambar latar belakang Anda
        $mpdf->showWatermarkImage = true;
        $mpdf->watermarkImageAlpha = 1;
        $data = self::preparedata($surat[0]);
        $mpdf->WriteHTML(view('suratmasuk',$data)->render());
        $mpdf->Output(storage_path('app/public/surat/'.$filename.'.pdf'), \Mpdf\Output\Destination::FILE);

        $requestdc = visit_dc::findOrFail($surat[0]->uuid_visitdc);
        $requestdc->update([
            'file_surat' => asset('storage/surat/'.$filename.'.pdf')
        ]);
        return response()->json([
            "status" => true,
            "message"=> "Surat berhasil di buat",
            "data"   => asset('storage/surat/'.$filename.'.pdf')
        ]);
        // $mpdf->Output($filename.'.pdf', \Mpdf\Output\Destination::INLINE);
    }
    public function suratkeluar($id){
        $key = base64_decode(urldecode($id));
        $surat = surat::with('product.productdetail')->where('no_surat',$key)->get();

        if(count($surat) == 0){
            return response()->json([
                "status" => false,
                "message"=> "Data Surat tidak ditemukan ",
                "data"   => ''
            ]);
        }
        // Membuat objek mPDF
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);

        // Menambahkan konten ke mPDF
        $filename = 'Unloading '.$surat[0]->company_name.'-'.Carbon::now()->isoFormat('D-M-Y');
        $mpdf->SetTitle($filename);
        // $mpdf->AddFont('arial', '', resource_path('font/arial.ttf'));
        // $mpdf->SetFont('arial');
        $mpdf->SetWatermarkImage(storage_path('app/public/bg.png')); // Ganti dengan path ke gambar latar belakang Anda
        $mpdf->showWatermarkImage = true;
        $mpdf->watermarkImageAlpha = 1;
        $data = self::preparedata($surat[0]);
        $mpdf->WriteHTML(view('suratkeluar',$data)->render());
        $mpdf->Output(storage_path('app/public/surat/'.$filename.'.pdf'), \Mpdf\Output\Destination::FILE);

        $requestdc = visit_dc::findOrFail($surat[0]->uuid_visitdc);
        $requestdc->update([
            'file_surat' => asset('storage/surat/'.$filename.'.pdf')
        ]);
        return response()->json([
            "status" => true,
            "message"=> "Surat berhasil di buat",
            "data"   => asset('storage/surat/'.$filename.'.pdf')
        ]);
    }
    public function preparedata($data){
        $data = [
            'fullname'          => $data['fullname'],
            'phone_number'      => $data['phone_number'],
            'address'           => $data['address'],
            'email'             => $data['email'],
            'position'          => $data['position'],
            'nik'               => $data['nik'],
            'company_name'      => $data['company_name'],
            'company_npwp'      => $data['company_npwp'],
            'company_address'   => $data['company_address'],
            'no_surat'          => $data['no_surat'],
            'data_center'       => $data['data_center'],
            'no_rack'           => $data['no_rack'],
            'switch'            => $data['switch'],
            'port'              => $data['port'],
            'service'           => $data['service'],
            'os'                => $data['os'],
            'arsitektur'        => $data['arsitektur'],
            'control_panel'     => $data['control_panel'],
            'support_name'         => $data['support_name'],
            'support_position'     => $data['support_position'],
            'support_email'        => $data['support_email'],
            'client_signature'  => "data:image/png;base64,".base64_encode(file_get_contents(storage_path('app/public/'.$data['client_signature']))),
            'support_signature' => "data:image/png;base64,".base64_encode(file_get_contents(storage_path('app/public/'.$data['support_signature']))),
            'tanggal'           => self::tanggalKeTeks(Carbon::now()->isoFormat('dddd D M Y')),
            'produk'            => $data->product->productdetail,
            'QR'                => (new QRCode())->render(env("FE_URL")."ceksurat/".base64_encode($data['no_surat']))
        ];
        return $data;
    }
    function tanggalKeTeks($tanggal){
        // Pisahkan tanggal, bulan, dan tahun
        $pecah = explode(" ", $tanggal);
        $hari = $pecah[0];
        $tanggal = $pecah[1];
        $bulan = $pecah[2];
        $tahun = $pecah[3];

        // Daftar nama bulan dalam bahasa Indonesia
        $namaBulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        // Daftar angka dalam bahasa Indonesia
        $angka = [
            "nol", "satu", "dua", "tiga", "empat", "lima", "enam",
            "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
        ];

        // Ubah tanggal menjadi teks
        $teksTanggal = "";
        if($tanggal < 12){
            $teksTanggal = $angka[$tanggal];
        }elseif($tanggal < 20){
            $teksTanggal = $angka[$tanggal - 10] . " belas";
        }else{
            $angka[($tanggal / 10)] . " puluh " . $angka[$tanggal % 10];
        }
        // Ubah bulan menjadi teks
        $teksBulan = $namaBulan[$bulan - 1];

        // Ubah tahun menjadi teks
        $teksTahun = "";
        $tahun = (string)$tahun;
        for ($i = 0; $i < strlen($tahun); $i++) {
            $teksTahun .= $angka[$tahun[$i]] . " ";
        }

        return $hari. " Tanggal " . ucfirst($teksTanggal) . " Bulan " . ucfirst($teksBulan) . " Tahun Dua Ribu " . ucfirst($angka[$tahun[2]]). ' Puluh '. ucfirst($angka[$tahun[3]]);
    }

    public function getdata($id){
        return response()->json([
            "status"    => true,
            "message"   => "berhasil",
            "data"      => surat::where('uuid_visitdc', $id)->get()
        ]);
    }
    public function getbyNomor($id){
        $nomor = base64_decode($id);
        $data = surat::where('no_surat', $nomor)->select('no_surat', 'updated_at','uuid_visitdc')->get();

        if(count($data)>=1){
            $visit = visit_dc::where('UID',$data[0]['uuid_visitdc'])->select('file_surat')->get();
            $data[0]['url'] = $visit[0]['file_surat'];

            if(str_contains($visit[0]['file_surat'],'Installation')){
                $data[0]['prihal'] = 'Installation Server';
            }else{
                $data[0]['prihal'] = 'Unloading Server';
            }
            return response()->json([
                "status"    => true,
                "message"   => "data berhasil ditemukan",
                "data"      =>  $data
            ]);

        }else{
            return response()->json([
                "status"    => false,
                "message"   => "data tidak ditemukan",
                "data"      =>  $data
            ]);
        }
    }
}
