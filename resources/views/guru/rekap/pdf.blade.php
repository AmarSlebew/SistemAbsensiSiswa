<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi Siswa</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px double #333333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 0;
            color: #666666;
            font-size: 10px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .info-value {
            width: auto;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .data-table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dddddd;
            border-top: 1px solid #dddddd;
            color: #495057;
            font-weight: bold;
            text-align: left;
            padding: 6px 8px;
            font-size: 10px;
            text-transform: uppercase;
        }
        .data-table td {
            border-bottom: 1px solid #eeeeee;
            padding: 6px 8px;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-center {
            text-align: center;
        }
        .font-semibold {
            font-weight: bold;
        }
        .percentage-text {
            font-weight: bold;
        }
        .signature-container {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-space {
            height: 60px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Rekapitulasi Kehadiran Siswa</h1>
        <p>Sistem Informasi Absensi Sekolah &bull; Laporan Rekapitulasi Kumulatif</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Kelas</td>
            <td style="width: 10px;">:</td>
            <td class="info-value">{{ $classroom->name ?? '-' }}</td>
            
            <td class="info-label" style="padding-left: 40px;">Mata Pelajaran</td>
            <td style="width: 10px;">:</td>
            <td class="info-value">{{ $subject ? $subject->name : 'Semua Mata Pelajaran' }}</td>
        </tr>
        <tr>
            <td class="info-label">Periode Laporan</td>
            <td>:</td>
            <td class="info-value">
                @if($startDate && $endDate)
                    {{ \Carbon\Carbon::parse($startDate)->locale('id')->isoFormat('D MMMM Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->locale('id')->isoFormat('D MMMM Y') }}
                @elseif($startDate)
                    Mulai {{ \Carbon\Carbon::parse($startDate)->locale('id')->isoFormat('D MMMM Y') }}
                @elseif($endDate)
                    Sampai {{ \Carbon\Carbon::parse($endDate)->locale('id')->isoFormat('D MMMM Y') }}
                @else
                    Semua Periode Kehadiran
                @endif
            </td>
            
            <td class="info-label" style="padding-left: 40px;">Guru Pengajar</td>
            <td>:</td>
            <td class="info-value">{{ $teacher->user->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px; text-align: center;">No</th>
                <th>Nama Siswa</th>
                <th style="width: 90px;">NIS</th>
                <th style="width: 50px; text-align: center; color: #137333;">Hadir</th>
                <th style="width: 50px; text-align: center; color: #1a73e8;">Izin</th>
                <th style="width: 50px; text-align: center; color: #b06000;">Sakit</th>
                <th style="width: 50px; text-align: center; color: #c5221f;">Alpa</th>
                <th style="width: 70px; text-align: center;">Total Sesi</th>
                <th style="width: 80px; text-align: center;">% Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recapData as $i => $row)
                <tr>
                    <td class="text-center" style="color: #777777;">{{ $i + 1 }}</td>
                    <td class="font-semibold" style="color: #222222;">{{ $row->student->name }}</td>
                    <td style="color: #555555; font-family: monospace;">{{ $row->student->nis }}</td>
                    <td class="text-center font-semibold" style="color: #137333;">{{ $row->hadir }}</td>
                    <td class="text-center" style="color: #1a73e8;">{{ $row->izin }}</td>
                    <td class="text-center" style="color: #b06000;">{{ $row->sakit }}</td>
                    <td class="text-center font-semibold" style="color: #c5221f;">{{ $row->alpa }}</td>
                    <td class="text-center" style="color: #555555;">{{ $row->total }}</td>
                    <td class="text-center percentage-text" style="color: {{ $row->percentage >= 80 ? '#137333' : ($row->percentage >= 60 ? '#b06000' : '#c5221f') }};">
                        {{ $row->percentage }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-container">
        <div class="signature-box">
            <p>Guru Pengajar,</p>
            <div class="signature-space"></div>
            <p class="signature-name">{{ $teacher->user->name ?? '-' }}</p>
            @if(isset($teacher->nip))
                <p style="margin: 0; font-size: 10px; color: #666666;">NIP. {{ $teacher->nip }}</p>
            @endif
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
