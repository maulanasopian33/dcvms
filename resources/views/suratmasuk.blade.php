<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .page{
    /* margin-top: 3,5cm; */
    padding: 2cm 20px;
    font-size: 13px;
    color: #000;
    margin: 0;
    /* margin-bottom: 2cm;
    margin-left: 2cm;
    margin-right: 2cm; */
}
table{
    margin: 0;
}
td{
    vertical-align: top;
}
    </style>
</head>
<body>
    <div class="page">

        <p style="margin: 0; text-align: center; font-weight: bold;">BERITA ACARA SERAH TERIMA PERANGKAT DAN AKTIFASI LAYANAN</p>
        <p style="margin: 0; text-align: center;">Nomor : {{ $no_surat }}</p>
        <p>Hari ini, {{ $tanggal }}, yang bertandatangan dibawah ini :</p>
        <table>
            <tr>
                <td>
                    <table style="width: 100%; text-align: start; font-size: 13px;">
                        <tbody>
                            <tr>
                                <td style="width: 120px; max-width: 120px;">Nama Lengkap</td>
                                <td>:</td>
                                <td>{{ $fullname }}</td>
                            </tr>
                            <tr>
                                <td>Nomor KTP</td>
                                <td>:</td>
                                <td>{{ $nik }}</td>
                            </tr>
                            <tr>
                                <td>Alamat Lengkap</td>
                                <td>:</td>
                                <td>{{ $address }}</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>{{ $position }}</td>

                            </tr>
                            <tr>
                                <td>Alamat Email</td>
                                <td>:</td>
                                <td>{{ $email }}</td>

                            </tr>
                            <tr>
                                <td>No. Telephone</td>
                                <td>:</td>
                                <td>{{ $phone_number }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table style="width: 100%; text-align: start; font-size: 13px;">
                        <tbody>
                            <tr>
                                <td style="width: 130px; max-width: 130px;">Bertindak atas nama</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Nama Perusahaan</td>
                                <td>:</td>
                                <td>{{ $company_name }}</td>
                            </tr>
                            <tr>
                                <td>Nomor NPWP</td>
                                <td>:</td>
                                <td>{{ $company_npwp }}</td>
                            </tr>
                            <tr style="text-align: start;">
                                <td>Alamat Lengkap</td>
                                <td>:</td>
                                <td style="word-wrap: break-word">{{ $company_address }}</td>

                            </tr>
                            <tr>
                                <td>Nomor Telephone</td>
                                <td>:</td>
                                <td>{{ $phone_number }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <p>Dengan ini menyerahkan perangkat kepada PT. Semut Data Indonesia (ANTMEDIAHOST.COM) untuk ditempatkan di Data Center ANTMEDIAHOST.COM dengan rincian sebagai berikut : </p>
        <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
            <thead>
                <tr>
                    <td style="padding: 5px; background-color: #4784ca; border: 1px solid #646464; text-align: center; color: white;">NO</td>
                    <td style="padding: 5px; background-color: #4784ca; border: 1px solid #646464; text-align: center; color: white;">JENIS PERANGKAT</td>
                    <td style="padding: 5px; background-color: #4784ca; border: 1px solid #646464; text-align: center; color: white;">DESKRIPSI</td>
                    <td style="padding: 5px; background-color: #4784ca; border: 1px solid #646464; text-align: center; color: white;">NO. SERI</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $item)
                    <tr>
                        <td style="padding: 5px; border: 1px solid #646464; text-align: center;">{{ $loop->index+1 }}</td>
                        <td style="padding: 5px; border: 1px solid #646464; text-align: center;">{{ $item->ukuran }} — {{ $item->jenis_server }}</td>
                        <td style="padding: 5px; border: 1px solid #646464; text-align: center;">{{ $item->merek }}</td>
                        <td style="padding: 5px; border: 1px solid #646464; text-align: center;">{{ $item->SN }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Untuk selanjutnya dilakukan aktifasi dan installasi perangkat tersebut : </p>
        <table style="width: 100%;">
            <tr>
                <td>
                    <table style="text-align: start; font-size: 13px;">
                        <tbody>
                            <tr>
                                <td>Lokasi Datacenter</td>
                                <td>:</td>
                                <td>{{ $data_center }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Rack Server</td>
                                <td>:</td>
                                <td>{{ $no_rack }}</td>
                            </tr>
                            <tr>
                                <td>Switch</td>
                                <td>:</td>
                                <td>{{ $switch }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Port</td>
                                <td>:</td>
                                <td>{{ $port }}</td>

                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table style=" text-align: start; font-size: 13px;">
                        <tbody>
                            <tr>
                                <td>Jenis layanan</td>
                                <td>:</td>
                                <td>{{ $service }}</td>
                            </tr>
                            <tr>
                                <td>Sistem Operasi</td>
                                <td>:</td>
                                <td>{{ $os }}</td>
                            </tr>
                            <tr>
                                <td>Arsitektur</td>
                                <td>:</td>
                                <td>{{ $arsitektur }}</td>

                            </tr>
                            <tr>
                                <td>Control Panel</td>
                                <td>:</td>
                                <td>{{ $control_panel }}</td>

                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <ol>
            <li>Bersama Dokumen ini terlampir salinan KTP/Kartu Identitas lainnya dari nama tersebut diatas.</li>
            <li>Salinan Dokumen ini akan dikirimkan oleh PT. Semut Data Indonesia (ANTMEDIAHOST) setelah di tandatangani dan berikan stempel perusahaan.</li>
            <li>Masa berlaku dokumen ini merujuk pada Waktu Layanan yang tertera.</li>
            <li>Staf PT. Semut Data Indonesia (ANTMEDIAHOST) wajib menyerahkan dokumen ini kepada pengelola dokumentasi untuk kepentingan arsip.</li>
        </ol>
        <table style="width: 100%;">
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td style="font-size: 13px;">
                                <p style="font-weight: bold;">PT Semutdata indonesia</p>

                            </td>
                            <td style="font-size: 13px;">
                                <p style="font-weight: bold;">{{ $company_name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px;">
                                <img src="{{ $support_signature }}" width="50px" height="50px" alt="">
                                <p>{{ $support_name }}</p>
                            </td>
                            <td style="font-size: 13px;">
                                <img src="{{ $client_signature }}" width="50px" height="50px" alt="">
                                <p>{{ $fullname }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <img src="{{ $QR }}" alt="" width="60px">
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

