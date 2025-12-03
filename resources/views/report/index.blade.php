<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mahasiswa</title>
    <style>
        body { font-family: Arial; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #eee; }
        .btn { padding: 10px 15px; margin-right: 10px; background: #007BFF; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn-green { background: green; }
        .btn-purple { background: purple; }
    </style>
</head>
<body>

<h2>Laporan Nilai Mahasiswa Per Jurusan</h2>

<a href="{{ route('report.export') }}" class="btn btn-green">📄 Export Excel</a>
<a href="{{ route('report.sendWa') }}" class="btn btn-purple">📤 Kirim ke WhatsApp</a>

<table>
    <tr>
        <th>M#</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Jurusan</th>
        <th>IPK</th>
    </tr>

    @foreach ($data as $m)
    <tr>
        <td>{{ $m->m_id }}</td>
        <td>{{ $m->nim }}</td>
        <td>{{ $m->nama }}</td>
        <td>{{ $m->jenisKelamin->description ?? '' }}</td>
        <td>{{ $m->jurusan }}</td>
        <td>{{ $m->ipk }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
