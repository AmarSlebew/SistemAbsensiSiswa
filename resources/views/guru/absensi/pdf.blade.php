<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kehadiran Siswa</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            font-size: 12px;
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
        .summary-title {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 8px;
            color: #444444;
        }
        .summary-container {
            width: 100%;
            margin-bottom: 25px;
        }
        .summary-box {
            width: 18%;
            float: left;
            border: 1px solid #dddddd;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
            margin-right: 2%;
        }
        .summary-box-last {
            margin-right: 0;
        }
        .summary-count {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .summary-label {
            font-size: 10px;
            color: #666666;
            text-transform: uppercase;
            font-weight: bold;
        }
        .clear {
            clear: both;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .data-table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dddddd;
            color: #495057;
            font-weight: bold;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
        }
        .data-table td {
            border-bottom: 1px solid #eeeeee;
            padding: 8px 10px;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) {
            background-color: #fafafa;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
            text-align: center;
        }
        .badge-hadir {
            background-color: #e6f4ea;
            color: #137333;
            border: 1px solid #ceead6;
        }
        .badge-izin {
            background-color: #e8f0fe;
            color: #1a73e8;
            border: 1px solid #d2e3fc;
        }
        .badge-sakit {
            background-color: #fef7e0;
            color: #b06000;
            border: 1px solid #feebc8;
        }
        .badge-alpa {
            background-color: #fce8e6;
            color: #c5221f;
            border: 1px solid #fad2cf;
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
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Kehadiran Siswa</h1>
        <p>Sistem Informasi Absensi Sekolah &bull; Laporan Resmi Guru Mata Pelajaran</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Kelas</td>
            <td style="width: 10px;">:</td>
            <td class="info-value">{{ $attendance->classroom->name ?? '-' }}</td>
            
            <td class="info-label" style="padding-left: 40px;">Mata Pelajaran</td>
            <td style="width: 10px;">:</td>
            <td class="info-value">{{ $attendance->subject->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Tanggal Sesi</td>
            <td>:</td>
            <td class="info-value">{{ \Carbon\Carbon::parse($attendance->date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
            
            <td class="info-label" style="padding-left: 40px;">Guru Pengajar</td>
            <td>:</td>
            <td class="info-value">{{ $attendance->teacher->user->name ?? '-' }}</td>
        </tr>
    </table>

    <div class="summary-title">Ringkasan Sesi Kehadiran</div>
    <div class="summary-container">
        <div class="summary-box">
            <div class="summary-count" style="color: #137333;">{{ $summary['hadir'] }}</div>
            <div class="summary-label">Hadir</div>
        </div>
        <div class="summary-box">
            <div class="summary-count" style="color: #1a73e8;">{{ $summary['izin'] }}</div>
            <div class="summary-label">Izin</div>
        </div>
        <div class="summary-box">
            <div class="summary-count" style="color: #b06000;">{{ $summary['sakit'] }}</div>
            <div class="summary-label">Sakit</div>
        </div>
        <div class="summary-box">
            <div class="summary-count" style="color: #c5221f;">{{ $summary['alpa'] }}</div>
            <div class="summary-label">Alpa</div>
        </div>
        <div class="summary-box summary-box-last" style="border-color: #495057; background-color: #f8f9fa;">
            <div class="summary-count" style="color: #495057;">{{ $summary['total'] }}</div>
            <div class="summary-label">Total Siswa</div>
        </div>
        <div class="clear"></div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th style="width: 120px;">NIS</th>
                <th>Nama Siswa</th>
                <th style="width: 100px; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendance->details->sortBy('student.name') as $i => $detail)
                <tr>
                    <td style="text-align: center; color: #777777;">{{ $i + 1 }}</td>
                    <td style="color: #555555; font-family: monospace;">{{ $detail->student->nis }}</td>
                    <td style="font-weight: bold; color: #222222;">{{ $detail->student->name }}</td>
                    <td style="text-align: center;">
                        @php
                            $badgeClass = match($detail->status) {
                                'Hadir' => 'badge-hadir',
                                'Izin'  => 'badge-izin',
                                'Sakit' => 'badge-sakit',
                                'Alpa'  => 'badge-alpa',
                                default => '',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $detail->status }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-container">
        <div class="signature-box">
            <p>Guru Pengajar,</p>
            <div class="signature-space"></div>
            <p class="signature-name">{{ $attendance->teacher->user->name ?? '-' }}</p>
            @if(isset($attendance->teacher->nip))
                <p style="margin: 0; font-size: 10px; color: #666666;">NIP. {{ $attendance->teacher->nip }}</p>
            @endif
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
