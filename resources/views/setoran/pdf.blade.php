<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .judul-bagian {
            background: #E3E6F5;
            padding: 6px;
            margin-top: 15px;
            font-weight: bold;
            border: 1px solid #000;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #ADB6E8; }
    </style>
</head>
<body>

<h2>REKAP TOTAL PER JENIS SAMPAH</h2>

<p style="text-align:center;">
    @if ($tanggal == "Semua Tanggal")
        Semua Tanggal
    @else
        Tanggal: {{ $tanggal }}
    @endif
</p>

@foreach ($rekap as $r)
    <div class="judul-bagian">{{ strtoupper($r['jenis_sampah']) }}</div>

    <table>
        <tr>
            <th>Total KG</th>
            <td>{{ number_format($r['total_kg'], 2) }}</td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>Rp {{ number_format($r['total_harga']) }}</td>
        </tr>
    </table>
@endforeach

<div class="judul-bagian">TOTAL KESELURUHAN</div>

<table>
    <tr>
        <th>Total Semua KG</th>
        <td>{{ number_format($totalKgAll, 2) }}</td>
    </tr>
    <tr>
        <th>Total Semua Harga</th>
        <td>Rp {{ number_format($totalRpAll) }}</td>
    </tr>
</table>

</body>
</html>
