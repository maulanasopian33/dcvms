<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Notif</title>
</head>
<body>
    <p>Dear Teams</p>
    <p>Request Datacenter diterima untuk tanggal {{ $details['tanggal'] }} di {{ $details['dc'] }}, dengan detail sebagai berikut :</p>
    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $details['nama'] }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{ $details['email'] }}</td>
        </tr>
        <tr>
            <td>Perusahaan</td>
            <td>:</td>
            <td>{{ $details['perusahaan'] }}</td>
        </tr>
        <tr>
            <td>Datacenter</td>
            <td>:</td>
            <td>{{ $details['dc'] }}</td>
        </tr>
        <tr>
            <td>Keperluan</td>
            <td>:</td>
            <td>{{ $details['keperluan'] }}</td>
        </tr>
    </table>
    <p>Untuk informasi lebih lanjut, silahkan mengakses link berikut</p>
    <a href="{{ $details['url'] }}">{{ $details['url'] }}</a>

    <p>Signature,</p>
    <p>DCMS Apps</p>
</body>
</html>
