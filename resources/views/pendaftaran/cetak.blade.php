<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - {{ $pendaftaran->nomor_registrasi }}</title>
    <style>
        .uppercase {
            text-transform: uppercase;
        }
        table td {
            text-transform: uppercase;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 16px;
            font-weight: normal;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }
        table th {
            background-color: #f0f0f0;
            text-align: left;
        }
        .section-title {
            background-color: #ddd;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
        }
        .foto-container {
            width: 120px;
            height: 160px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
        }
        .foto-container img {
            max-width: 100%;
            max-height: 100%;
        }
        .ttd-area {
            margin-top: 50px;
            width: 220px;
            text-align: center;
            float: left;
        }
        .foto-area {
            float: right;
            margin-top: 50px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
                margin: 0;
            }
        }
        .persyaratan {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        
        .persyaratan h4 {
            margin-top: 0;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
        
        .alamat {
            margin-top: 15px;
            padding: 15px;
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #f0f8ff;
        }
        
        .alamat h4 {
            margin-top: 0;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }        
    </style>
</head>
<body>
    <div class="header">
        <h1>Formulir Pendaftaran Peserta Didik Baru</h1>
        <h1>{{ $pendaftaran->jenjang }} Tahfizhul Qur'an Miftahu Khairil Ummah</h1>
        <h1>Tahun Ajaran 2025/2026</h1>
    </div>

    <table>
        <tr>
            <th width="25%">Nomor Registrasi</th>
            <td width="25%">{{ $pendaftaran->nomor_registrasi }}</td>
            <th width="25%">Jenis Pendaftaran</th>
            <td width="25%">{{ $pendaftaran->tipe_santri }}</td>
        </tr>
        <tr>
            <th>Gelombang</th>
            <td>Gelombang {{ $pendaftaran->gelombang->nomor_gelombang }}</td>
            <th>Kelas</th>
            <td>
                @if($pendaftaran->jenjang == 'KAUD')
                    Kelas {{ $pendaftaran->kelas }}
                @else
                    Kelas {{ $pendaftaran->kelas }}
                @endif    
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <th colspan="4" class="section-title">Data Pribadi Santri</th>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td colspan="3" class="uppercase" >{{ $pendaftaran->nama_lengkap }}</td>
        </tr>
        <tr>
            <th>Nama Panggilan</th>
            <td colspan="3" class="uppercase">{{ $pendaftaran->nama_panggilan }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td colspan="3" class="uppercase">{{ $pendaftaran->jenis_kelamin_santri }}</td>
        </tr>
        <tr>
            <th>Tempat, Tanggal Lahir</th>
            <td colspan="3" class="uppercase">{{ $pendaftaran->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <th>Usia (1 Juli 2026)</th>
            <td colspan="3">{{ $pendaftaran->usia_pendaftaran }}</td>
        </tr>
        <tr>
            <th>Anak Ke</th>
            <td>{{ $pendaftaran->anak_ke }}</td>
            <th>Dari</th>
            <td>{{ $pendaftaran->dari_berapa_bersaudara }} bersaudara</td>
        </tr>
        <tr>
            <th>Status dalam Keluarga</th>
            <td colspan="3" class="uppercase">{{ $pendaftaran->status_dalam_keluarga }}</td>
        </tr>
        <tr>
            <th>Alamat Lengkap</th>
            <td colspan="3" class="uppercase">{{ $pendaftaran->alamat_lengkap }}</td>
        </tr>
        <tr>
            <th>Asal Sekolah</th>
            <td colspan="3" class="uppercase">{{ $pendaftaran->asal_sekolah ?? '-' }}</td>
        </tr>
        <tr>
            <th>NIK (Nomor Induk Kependudukan)</th>
            <td colspan="3">
                @if($pendaftaran->nik === '0')
                    TIDAK TAHU
                @else
                    {{ $pendaftaran->nik }}
                @endif
            </td>    
        </tr>
        <tr>
            <th>NISN (Nomor Induk Siswa Nasional)</th>
            <td colspan="3">
                @if($pendaftaran->nisn === '0')
                    TIDAK TAHU
                @else
                    {{ $pendaftaran->nisn }}
                @endif    
        </tr>
        <tr>
            <th>Catatan Khusus</th>
            <td colspan="3" class="uppercase">{{ $pendaftaran->catatan_khusus ?? '-' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th colspan="4" class="section-title">Data Orang Tua Kandung</th>
        </tr>
        <tr>
            <th>Orang Tua Kandung yang Ada</th>
            <td colspan="3">{{ $pendaftaran->status_orang_tua }}</td>
        </tr>        
        <tr>
            <th colspan="2">Ayah Kandung</th>
            <th colspan="2">Ibu Kandung</th>
        </tr>
        <tr>
            <th width="25%">Nama Lengkap</th>
            <td width="25%" class="uppercase">{{ $pendaftaran->nama_ayah }}</td>
            <th width="25%">Nama Lengkap</th>
            <td width="25%" class="uppercase">{{ $pendaftaran->nama_ibu }}</td>
        </tr>
        <tr>
            <th>Pekerjaan</th>
            <td class="uppercase">{{ $pendaftaran->pekerjaan_ayah }}</td>
            <th>Pekerjaan</th>
            <td class="uppercase">{{ $pendaftaran->pekerjaan_ibu }}</td>
        </tr>
        <tr>
            <th>Penghasilan</th>
            <td class="uppercase">{{ $pendaftaran->penghasilan_ayah }}</td>
            <th>Penghasilan</th>
            <td class="uppercase">{{ $pendaftaran->penghasilan_ibu }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td class="uppercase">{{ $pendaftaran->alamat_ayah }}</td>
            <th>Alamat</th>
            <td class="uppercase">{{ $pendaftaran->alamat_ibu }}</td>
        </tr>
        <tr>
            <th>Kontak (WhatsApp)</th>
            <td class="uppercase">{{ $pendaftaran->kontak_ayah }}</td>
            <th>Kontak (WhatsApp)</th>
            <td class="uppercase">{{ $pendaftaran->kontak_ibu }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th colspan="4" class="section-title">Data Wali Penanggung Jawab Pendidikan</th>
        </tr>
        <tr>
            <th width="25%">Wali Penanggung Jawab</th>
            <td colspan="3">{{ $pendaftaran->wali_penanggung_jawab }}</td>
        </tr>
        @if($pendaftaran->wali_penanggung_jawab == 'Lainnya')
        <tr>
            <th>Nama Lengkap Wali</th>
            <td class="uppercase">{{ $pendaftaran->nama_wali }}</td>
            <th>Pekerjaan Wali</th>
            <td class="uppercase">{{ $pendaftaran->pekerjaan_wali }}</td>
        </tr>
        <tr>
            <th>Penghasilan Wali</th>
            <td class="uppercase">{{ $pendaftaran->penghasilan_wali }}</td>
            <th>Kontak Wali</th>
            <td class="uppercase">{{ $pendaftaran->kontak_wali }}</td>
        </tr>
        <tr>
            <th>Alamat Wali</th>
            <td colspan="3">{{ $pendaftaran->alamat_wali }}</td>
        </tr>
        @endif
    </table>
    <div class="persyaratan">
        <h4>PERSYARATAN DOKUMEN YANG HARUS DISERAHKAN</h4>
        <p>Calon peserta didik wajib menyerahkan dokumen berikut:</p>
        <ol>
            <li>Fotokopi Kartu Keluarga (KK) 2 lembar</li>
            <li>Fotokopi Akta Kelahiran 2 lembar</li>
            <li>Fotokopi KTP Orang Tua 2 lembar</li>
            @if($pendaftaran->status_orang_tua === 'Hanya Ibu' || $pendaftaran->status_orang_tua === 'Tidak Keduanya')
            <li>Akta Kematian Ayah (bagi yatim) 2 lembar</li>
            @endif
            <li>Pas foto 3x4 (yang telah diupload)</li>
            <li>Bukti transfer formulir (yang telah diupload)</li>
        </ol>
    </div>

    <div class="alamat">
        <h4>ALAMAT PENYERAHAN DOKUMEN</h4>
        <p>Serahkan dokumen persyaratan tersebut ke:</p>
        <p>
            <strong>Panitia PPDB Miftahu Khairil Ummah</strong><br>
            Ruang Kantor Ikhwan Miftahu Khairil Ummah<br>
            Taman Wisma Asri II<br>
            Jl. Delima V Blok D14<br>
            Teluk Pucung, Bekasi Utara<br>
            Kota Bekasi, Jawa Barat<br>
            <strong>Kode Pos: 17121</strong>
        </p>
        <p>
            <strong>Informasi Kontak:</strong><br>
            WhatsApp: 081 511 333 511 (Yayasan RISTAWA)<br>
            WhatsApp: 0851 7343 5658 (Administrasi/Tata Usaha)<br>
            Email: ppdb@mku.or.id
        </p>
        <p>
            <strong>Jam Operasional:</strong><br>
            Senin - Jumat: 08.00 - 14.00 WIB<br>
            Sabtu: 08.00 - 11.00 WIB<br>
            Minggu: Libur
        </p>
    </div>

    <div class="clearfix">
        <div class="ttd-area">
            <p>Hormat kami,</p>
            <p>Orang Tua/Wali Calon Santri</p>
            <br><br><br>
            <p>(___________________)</p>
        </div>
        
        <div class="foto-area">
            <div class="foto-container">
                @if($pendaftaran->pas_foto_path)
                    <img src="{{ storage_path('app/public/' . $pendaftaran->pas_foto_path) }}" alt="Pas Foto">
                @else
                    <p>Foto 3x4</p>
                @endif
            </div>
        </div>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
            Cetak Formulir
        </button>
        <a href="{{ route('pendaftaran.pdf', $pendaftaran->uuid) }}" style="padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px;">
            Simpan sebagai PDF
        </a>
    </div>
</body>
</html>