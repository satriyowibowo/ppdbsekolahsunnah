@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="step-progress">
            <div class="step completed">
                <div class="step-number">1</div>
                <div class="step-label">Jenjang</div>
            </div>
            <div class="step completed">
                <div class="step-number">2</div>
                <div class="step-label">Jenis Kelamin</div>
            </div>
            <div class="step active">
                <div class="step-number">3</div>
                <div class="step-label">Formulir</div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header text-center">
                <h3>Formulir Pendaftaran - {{ session('jenjang') }} {{ session('jenis_kelamin') }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <h4 class="border-bottom pb-2">Informasi Pendaftaran</h4>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Gelombang Pendaftaran</label>
                            <div class="col-sm-9">
                                <select name="gelombang_id" class="form-select" required>
                                    <option value="">Pilih Gelombang</option>
                                    @foreach($gelombangs as $gelombang)
                                        <option value="{{ $gelombang->id }}">{{ $gelombang->periode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Tipe Santri</label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipe_santri" id="tipe_baru" value="Baru" checked onchange="toggleKelas()">
                                    <label class="form-check-label" for="tipe_baru">Santri Baru</label>
                                </div>
                                <div class="form-check form-check-inline" id="pindahan_container">
                                    <input class="form-check-input" type="radio" name="tipe_santri" id="tipe_pindahan" value="Pindahan" onchange="toggleKelas()">
                                    <label class="form-check-label" for="tipe_pindahan">Santri Pindahan</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Kelas</label>
                            <div class="col-sm-9">
                                <select name="kelas" id="kelas" class="form-select" required>
                                    @if(session('jenjang') == 'KAUD')
                                        <option value="A">Kelas A</option>
                                        <option value="B">Kelas B</option>
                                    @else    
                                        <option value="1">Kelas I (Satu)</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="border-bottom pb-2">Data Pribadi Santri</h4>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_lengkap" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Nama Panggilan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_panggilan" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin_santri" id="laki" value="Laki-laki" checked>
                                    <label class="form-check-label" for="laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin_santri" id="perempuan" value="Perempuan">
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="tempat_lahir" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="tanggal_lahir" required onchange="hitungUsia()">
                                <small class="form-text text-muted">Usia per 1 Juli 2026: <span id="usia">-</span></small>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Anak Ke</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="anak_ke" min="1" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Dari Berapa Bersaudara</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="dari_berapa_bersaudara" min="1" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status dalam Keluarga</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status_dalam_keluarga" id="status_keluarga" onchange="toggleStatusLainnya()">
                                    <option value="Anak Kandung">Anak Kandung</option>
                                    <option value="Anak Tiri">Anak Tiri</option>
                                    <option value="Anak Angkat">Anak Angkat</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <div id="status_lainnya_container" class="mt-2" style="display: none;">
                                    <input type="text" class="form-control" name="status_dalam_keluarga_lainnya" placeholder="Status lainnya">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Alamat Lengkap Domisili</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="alamat_lengkap" rows="3" required></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Catatan Khusus</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="catatan_khusus" rows="3" placeholder="Penyakit yang pernah diderita, alergi, dll."></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Asal Sekolah</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="asal_sekolah">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">NIK (Nomor Induk Kependudukan)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nik" required 
                                    oninput="formatNIK(this)">
                                <small class="form-text text-muted">Wajib diisi. Jika tidak tahu, cukup isi dengan angka 0 (nol) saja</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">NISN (Nomor Induk Siswa Nasional)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nisn" required 
                                    oninput="formatNISN(this)">
                                <small class="form-text text-muted">Wajib diisi. Jika tidak tahu, cukup isi dengan angka 0 (nol) saja</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="border-bottom pb-2">Data Orang Tua Kandung</h4>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Orang Tua Kandung yang Masih Hidup</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status_orang_tua" required>
                                    <option value="Ayah dan Ibu">Ayah dan Ibu</option>
                                    <option value="Hanya Ayah">Hanya Ayah</option>
                                    <option value="Hanya Ibu">Hanya Ibu</option>
                                    <option value="Tidak Keduanya">Tidak Keduanya</option>
                                </select>
                            </div>
                        </div>                        
                        <h5 class="mt-3">Ayah Kandung</h5>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_ayah" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Pekerjaan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pekerjaan_ayah" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Penghasilan per Bulan</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="penghasilan_ayah" required>
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="Kurang dari Rp2.000.000">Kurang dari Rp2.000.000</option>
                                    <option value="Rp2.000.000 - Rp4.000.000">Rp2.000.000 - Rp4.000.000</option>
                                    <option value="Lebih dari Rp5.000.000">Lebih dari Rp5.000.000</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Alamat Domisili</label>
                            <div class="col-sm-9">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="alamat_ayah_idem" onchange="toggleAlamat('ayah')">
                                    <label class="form-check-label" for="alamat_ayah_idem">Sama dengan alamat santri</label>
                                </div>
                                <textarea class="form-control" name="alamat_ayah" rows="3" required></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Kontak Aktif (WhatsApp)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="kontak_ayah" required>
                            </div>
                        </div>
                        
                        <h5 class="mt-4">Ibu Kandung</h5>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_ibu" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Pekerjaan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pekerjaan_ibu" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Penghasilan per Bulan</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="penghasilan_ibu" required>
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="Kurang dari Rp2.000.000">Kurang dari Rp2.000.000</option>
                                    <option value="Rp2.000.000 - Rp4.000.000">Rp2.000.000 - Rp4.000.000</option>
                                    <option value="Lebih dari Rp5.000.000">Lebih dari Rp5.000.000</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Alamat Domisili</label>
                            <div class="col-sm-9">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="alamat_ibu_idem" onchange="toggleAlamat('ibu')">
                                    <label class="form-check-label" for="alamat_ibu_idem">Sama dengan alamat santri</label>
                                </div>
                                <textarea class="form-control" name="alamat_ibu" rows="3" required></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Kontak Aktif (WhatsApp)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="kontak_ibu" required>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="border-bottom pb-2">Data Wali Penanggung Jawab Pendidikan</h4>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Wali Penanggung Jawab</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="wali_penanggung_jawab" id="wali_penanggung_jawab" onchange="toggleWali()" required>
                                    <option value="Ayah">Ayah</option>
                                    <option value="Ibu">Ibu</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        
                        <div id="wali_lainnya_container">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nama Lengkap Wali</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_wali">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Pekerjaan Wali</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="pekerjaan_wali">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Penghasilan Wali per Bulan</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="penghasilan_wali">
                                        <option value="">Pilih Penghasilan</option>
                                        <option value="Kurang dari Rp2.000.000">Kurang dari Rp2.000.000</option>
                                        <option value="Rp2.000.000 - Rp4.000.000">Rp2.000.000 - Rp4.000.000</option>
                                        <option value="Lebih dari Rp5.000.000">Lebih dari Rp5.000.000</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Alamat Wali</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="alamat_wali" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Kontak Aktif Wali (WhatsApp)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="kontak_wali">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="border-bottom pb-2">Informasi Biaya dan Transfer</h4>
                        
                        <div class="alert alert-info">
                            <h5>Biaya Formulir Pendaftaran: 
                                @if(session('jenjang') == 'KAUD')
                                    Rp 100.000
                                @else
                                    Rp 200.000
                                @endif
                            </h5>
                            <p class="mb-1">Rekening untuk Transfer:</p>
                            <p class="mb-1">Bank: BSI (Bank Syariah Indonesia)</p>
                            <p class="mb-1">No. Rekening: 7211 542 513</p>
                            <p class="mb-1">Atas Nama: MIFTAHU KHAIRIL UMMAH RISTAWA</p>
                            <p class="mb-0">Berita: Pendaftaran [Nama Santri]</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="border-bottom pb-2">Upload Berkas</h4>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Pas Foto 3x4</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="pas_foto" accept=".jpg,.jpeg,.png" required>
                                <small class="form-text text-muted">Maksimal 3MB, format JPG/JPEG/PNG</small>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Bukti Transfer</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="bukti_transfer" accept=".jpg,.jpeg,.png" required>
                                <small class="form-text text-muted">Maksimal 3MB, format JPG/JPEG/PNG</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Kirim Formulir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleKelas() {
        const tipeSantri = document.querySelector('input[name="tipe_santri"]:checked').value;
        const kelasSelect = document.getElementById('kelas');
        const jenjang = "{{ session('jenjang') }}";
        
        kelasSelect.innerHTML = '';
        
        if (jenjang === 'KAUD') {
            kelasSelect.innerHTML = '<option value="A">Kelas A</option>' +
                                    '<option value="B">Kelas B</option>';
        } else {
            if (tipeSantri === 'Baru') {
                kelasSelect.innerHTML = '<option value="1">Kelas I (Satu)</option>';
            } else {
                kelasSelect.innerHTML = '<option value="2">Kelas II (Dua)</option>' +
                                        '<option value="3">Kelas III (Tiga)</option>' +
                                        '<option value="4">Kelas IV (Empat)</option>';            
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const jenjang = "{{ session('jenjang') }}";
        if (jenjang === 'KAUD') {
            document.getElementById('tipe_pindahan').parentElement.style.display = 'none';
            document.getElementById('tipe_baru').checked = true;
            toggleKelas();
        }
    });
    
    function hitungUsia() {
        const tanggalLahir = new Date(document.querySelector('input[name="tanggal_lahir"]').value);
        const tanggalReferensi = new Date(2026, 6, 1); // 1 Juli 2026
        
        if (isNaN(tanggalLahir.getTime())) {
            document.getElementById('usia').textContent = '-';
            return;
        }
        
        let tahun = tanggalReferensi.getFullYear() - tanggalLahir.getFullYear();
        let bulan = tanggalReferensi.getMonth() - tanggalLahir.getMonth();
        let hari = tanggalReferensi.getDate() - tanggalLahir.getDate();
        
        if (hari < 0) {
            bulan--;
            // Hari dalam bulan sebelumnya
            const lastDayOfMonth = new Date(
                tanggalReferensi.getFullYear(), 
                tanggalReferensi.getMonth(), 
                0
            ).getDate();
            hari += lastDayOfMonth;
        }
        
        if (bulan < 0) {
            tahun--;
            bulan += 12;
        }
        
        document.getElementById('usia').textContent = 
            `${tahun} tahun ${bulan} bulan ${hari} hari`;
    }
    
    function formatNIK(input) {
        if (input.value === '0') {
            return;
        }
        input.value = input.value.replace(/[^0-9]/g, '').slice(0, 16);
    }

    function formatNISN(input) {
        if (input.value === '0') {
            return;
        }
        input.value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const nikInput = document.querySelector('input[name="nik"]');
                const nisnInput = document.querySelector('input[name="nisn"]');

                if (nikInput && nikInput.value !== '0' && !/^[0-9]{16}$/.test(nikInput.value)) {
                    e.preventDefault();
                    nikInput.focus();
                    return false;
                }
                if (nisnInput && nisnInput.value !== '0' && !/^[0-9]{10}$/.test(nisnInput.value)) {
                    e.preventDefault();
                    alert('NISN harus terdiri dari 10 digit angka. Jika tidak tahu, cukup isi dengan angka 0 saja');
                    nisnInput.focus();
                    return false;
                }
            });
        }
    });

    function toggleStatusLainnya() {
        const status = document.getElementById('status_keluarga').value;
        const container = document.getElementById('status_lainnya_container');
        
        if (status === 'Lainnya') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }
    
    function toggleAlamat(tipe) {
        const checkbox = document.getElementById(`alamat_${tipe}_idem`);
        const textarea = document.querySelector(`textarea[name="alamat_${tipe}"]`);
        const alamatSantri = document.querySelector('textarea[name="alamat_lengkap"]').value;
        
        if (checkbox.checked) {
            textarea.value = alamatSantri;
            textarea.readOnly = true;
        } else {
            textarea.value = '';
            textarea.readOnly = false;
        }
    }
    
    function toggleWali() {
        const wali = document.getElementById('wali_penanggung_jawab').value;
        const container = document.getElementById('wali_lainnya_container');
        
        if (wali === 'Lainnya') {
            container.style.display = 'block';
            container.querySelectorAll('input, select, textarea').forEach(el => {
                el.setAttribute('required', 'required');
            });
        } else {
            container.style.display = 'none';
            container.querySelectorAll('input, select, textarea').forEach(el => {
                el.removeAttribute('required');
            });
        }
    }
    
    function convertToUppercase(input) {
        input.value = input.value.toUpperCase();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const textInputs = document.querySelectorAll('input[type="text"], textarea');
        textInputs.forEach(input => {
            input.addEventListener('input', function() {
                convertToUppercase(this);
            });
            
            // Konversi nilai yang sudah ada (jika ada)
            if (input.value) {
                convertToUppercase(input);
            }
        });
    });

    const statusKeluarga = document.getElementById('status_keluarga');
        if (statusKeluarga) {
            statusKeluarga.addEventListener('change', function() {
                if (this.value === 'Lainnya') {
                    const lainnyaInput = document.querySelector('input[name="status_dalam_keluarga_lainnya"]');
                    if (lainnyaInput && lainnyaInput.value) {
                        convertToUppercase(lainnyaInput);
                    }
                }
            });
        }

    document.addEventListener('DOMContentLoaded', function() {
        toggleWali();
    });
</script>
@endpush
@endsection