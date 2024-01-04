<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .page{
    /* margin-top: 3,5cm; */
    padding: 1.5cm 20px;
    font-size: 13px;
    color: #000;
    margin: 0;
    font-family: Arial
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

        <p style="margin: 0; text-align: center; font-weight: bold;">BERITA ACARA SERAH TERIMA PERANGKAT</p>
        <p style="margin: 0; text-align: center;">Nomor : {{ $no_surat }}</p>
        <p>Hari ini, {{ $tanggal }}, yang bertandatangan dibawah ini :</p>
        <table style="text-align: start; margin-left: 20px; font-size: 13px;">
            <tbody>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td>mmmm</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $support_position }}</td>
                </tr>
                <tr>
                    <td>Alamat Email</td>
                    <td>:</td>
                    <td>{{ $support_email }}</td>
                </tr>
            </tbody>
        </table>
        <p>Bertindak sebagai pihak PT Semut data indonesia, dengan ini menyerahkan perangkat kepada : </p>
        <table style="margin-left: 20px; text-align: start; font-size: 13px;">
            <tbody>
                <tr>
                    <td>Nama Lengkap</td>
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
        <p>Dengan rincian sebagai berikut : </p>
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
        <ol>
            <li>Bersama Dokumen ini terlampir salinan KTP/Kartu Identitas lainnya dari nama tersebut diatas.</li>
            <li>Salinan Dokumen ini akan dikirimkan oleh PT. Semut Data Indonesia (ANTMEDIAHOST) setelah di tandatangani dan berikan stempel perusahaan.</li>
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
