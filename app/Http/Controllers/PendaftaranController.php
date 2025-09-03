<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Gelombang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    public function pilihJenjang()
    {
        return view('pendaftaran.jenjang');
    }

    public function pilihJenisKelamin(Request $request)
    {
        $request->validate([
            'jenjang' => 'required|in:KAUD,Kuttab'
        ]);
        
        session(['jenjang' => $request->jenjang]);
        
        return view('pendaftaran.jenis_kelamin');
    }

    public function form(Request $request)
    {
        $request->validate([
            'jenis_kelamin' => 'required|in:Ikhwan,Akhwat'
        ]);
        
        session(['jenis_kelamin' => $request->jenis_kelamin]);
        $gelombangs = Gelombang::where('status', true)
        ->get()
        ->map(function ($gelombang) {
            $gelombang->formatted_periode = "Gelombang {$gelombang->nomor_gelombang} (" . 
                \Carbon\Carbon::parse($gelombang->tanggal_mulai)->format('d M Y') . " - " . 
                \Carbon\Carbon::parse($gelombang->tanggal_selesai)->format('d M Y') . ")";
            return $gelombang;
        });
        
        return view('pendaftaran.form', compact('gelombangs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gelombang_id' => 'required|exists:gelombangs,id',
            'tipe_santri' => 'required|in:Baru,Pindahan',
            'kelas' => 'required|string',
            'nama_lengkap' => 'required|string|max:255|regex:/^[A-Z\s]+$/',
            'nama_panggilan' => 'required|string|max:100|regex:/^[A-Z\s]+$/',
            'jenis_kelamin_santri' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100|regex:/^[A-Z\s]+$/',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|integer|min:1',
            'dari_berapa_bersaudara' => 'required|integer|min:1',
            'status_dalam_keluarga' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'asal_sekolah' => 'nullable|string|max:255',
            'nik' => 'required',
            'nisn' => 'required',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:100',
            'penghasilan_ayah' => 'required|string|max:50',
            'alamat_ayah' => 'required|string',
            'kontak_ayah' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:100',
            'penghasilan_ibu' => 'required|string|max:50',
            'alamat_ibu' => 'required|string',
            'kontak_ibu' => 'required|string|max:20',
            'status_orang_tua' => 'required|in:Ayah dan Ibu,Hanya Ayah,Hanya Ibu,Tidak Keduanya',
            'wali_penanggung_jawab' => 'required|in:Ayah,Ibu,Lainnya',
            'nama_wali' => 'required_if:wali_penanggung_jawab,Lainnya|nullable|string|max:255',
            'pekerjaan_wali' => 'required_if:wali_penanggung_jawab,Lainnya|nullable|string|max:100',
            'penghasilan_wali' => 'required_if:wali_penanggung_jawab,Lainnya|nullable|string|max:50',
            'alamat_wali' => 'required_if:wali_penanggung_jawab,Lainnya|nullable|string',
            'kontak_wali' => 'required_if:wali_penanggung_jawab,Lainnya|nullable|string|max:20',
            'pas_foto' => 'required|image|mimes:jpg,jpeg,png|max:3000',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:3000'
        ],
        [
            'required' => 'Field :attribute wajib diisi.',
            'required_if' => 'Field :attribute wajib diisi ketika :other adalah :value.',
            'image' => 'File :attribute harus berupa gambar.',
            'mimes' => 'File :attribute harus memiliki format: :values.',
            'max' => 'File :attribute tidak boleh lebih dari :max kilobita.',
            'exists' => 'Pilihan :attribute tidak valid.'
        ]
        );
        
        $validator->after(function ($validator) use ($request) {
            if ($request->nik !== '0' && !preg_match('/^[0-9]{16}$/', $request->nik)) {
                $validator->errors()->add('nik', 'NIK harus terdiri dari 16 digit angka atau 0 jika tidak diketahui');
            }
            if ($request->nisn !== '0' && !preg_match('/^[0-9]{10}$/', $request->nisn)) {
                $validator->errors()->add('nisn', 'NISN harus terdiri dari 10 digit angka atau 0 jika tidak diketahui');
            }
        });


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $request->merge([
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'nama_panggilan' => strtoupper($request->nama_panggilan),
            'tempat_lahir' => strtoupper($request->tempat_lahir),
            'status_dalam_keluarga' => strtoupper($request->status_dalam_keluarga),
            'alamat_lengkap' => strtoupper($request->alamat_lengkap),
            'catatan_khusus' => strtoupper($request->catatan_khusus),
            'asal_sekolah' => strtoupper($request->asal_sekolah),
            'nama_ayah' => strtoupper($request->nama_ayah),
            'pekerjaan_ayah' => strtoupper($request->pekerjaan_ayah),
            'alamat_ayah' => strtoupper($request->alamat_ayah),
            'nama_ibu' => strtoupper($request->nama_ibu),
            'pekerjaan_ibu' => strtoupper($request->pekerjaan_ibu),
            'alamat_ibu' => strtoupper($request->alamat_ibu),
            'nama_wali' => strtoupper($request->nama_wali),
            'pekerjaan_wali' => strtoupper($request->pekerjaan_wali),
            'alamat_wali' => strtoupper($request->alamat_wali),
        ]);

        $nomorRegistrasi = Pendaftaran::generateNomorRegistrasi(
            $request->gelombang_id, 
            $request->kelas,
            session('jenjang')
        );

        $tanggalLahir = Carbon::parse($request->tanggal_lahir);
        $usia = Pendaftaran::hitungUsia($tanggalLahir);

        $pasFotoName = 'pas_foto_' . uniqid() . '.' . $request->file('pas_foto')->getClientOriginalExtension();
        $buktiTransferName = 'bukti_transfer_' . uniqid() . '.' . $request->file('bukti_transfer')->getClientOriginalExtension();

        $pasFotoPath = $request->file('pas_foto')->storeAs('pas_foto', $pasFotoName, 'public');
        $buktiTransferPath = $request->file('bukti_transfer')->storeAs('bukti_transfer', $buktiTransferName, 'public');

        $statusDalamKeluarga = $request->status_dalam_keluarga;
        if ($statusDalamKeluarga === 'Lainnya' && $request->has('status_dalam_keluarga_lainnya')) {
            $statusDalamKeluarga = $request->status_dalam_keluarga_lainnya;
        }

        $uuid = (string) Str::uuid();
        $pendaftaran = new Pendaftaran();
        $pendaftaran->fill($request->all());
        $pendaftaran->nomor_registrasi = $nomorRegistrasi;
        $pendaftaran->jenjang = session('jenjang');
        $pendaftaran->jenis_kelamin = session('jenis_kelamin');
        $pendaftaran->usia_pendaftaran = $usia;
        $pendaftaran->pas_foto_path = $pasFotoPath;
        $pendaftaran->bukti_transfer_path = $buktiTransferPath;
        if ($request->wali_penanggung_jawab === 'Ayah') {
            $pendaftaran->nama_wali = $request->nama_ayah;
            $pendaftaran->pekerjaan_wali = $request->pekerjaan_ayah;
            $pendaftaran->penghasilan_wali = $request->penghasilan_ayah;
            $pendaftaran->alamat_wali = $request->alamat_ayah;
            $pendaftaran->kontak_wali = $request->kontak_ayah;
        } elseif ($request->wali_penanggung_jawab === 'Ibu') {
            $pendaftaran->nama_wali = $request->nama_ibu;
            $pendaftaran->pekerjaan_wali = $request->pekerjaan_ibu;
            $pendaftaran->penghasilan_wali = $request->penghasilan_ibu;
            $pendaftaran->alamat_wali = $request->alamat_ibu;
            $pendaftaran->kontak_wali = $request->kontak_ibu;
        }
        $pendaftaran->save();

        session(['pendaftaran_uuid' => $pendaftaran->uuid]);
        session()->forget(['jenjang', 'jenis_kelamin']);
    
        return redirect()->route('pendaftaran.sukses', $pendaftaran->uuid)
            ->with('success', 'Pendaftaran berhasil disimpan. Nomor registrasi: ' . $nomorRegistrasi);

    }

    public function sukses(Pendaftaran $pendaftaran)
    {
        //$pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.sukses', compact('pendaftaran'));
    }

    public function cetakFormulir(Pendaftaran $pendaftaran)
    {
        if (session('pendaftaran_uuid') !== $pendaftaran->uuid) {
            abort(403, 'Akses ditolak.');
        }
        return view('pendaftaran.cetak', compact('pendaftaran'));
    }

    public function downloadPDF(Pendaftaran $pendaftaran)
    {
        if (session('pendaftaran_uuid') !== $pendaftaran->uuid) {
            abort(403, 'Akses ditolak.');
        }
        $pdf = PDF::loadView('pendaftaran.cetak', compact('pendaftaran'));
        return $pdf->download('formulir_pendaftaran_'.$pendaftaran->nomor_registrasi.'.pdf');
    }
}
