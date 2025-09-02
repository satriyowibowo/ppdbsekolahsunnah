<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000002_create_pendaftarans_table.php
    public function up()
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            
            // Informasi pendaftaran
            $table->string('nomor_registrasi')->unique();
            $table->foreignId('gelombang_id')->constrained('gelombangs');
            $table->enum('jenjang', ['KAUD', 'Kuttab']);
            $table->enum('jenis_kelamin', ['Ikhwan', 'Akhwat']);
            $table->enum('tipe_santri', ['Baru', 'Pindahan']);
            $table->integer('kelas')->nullable();
            
            // Data pribadi santri
            $table->string('nama_lengkap');
            $table->string('nama_panggilan');
            $table->enum('jenis_kelamin_santri', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('usia_pendaftaran');
            $table->integer('anak_ke');
            $table->integer('dari_berapa_bersaudara');
            $table->string('status_dalam_keluarga');
            $table->text('alamat_lengkap');
            $table->text('catatan_khusus')->nullable();
            $table->string('asal_sekolah')->nullable();
            
            // Data ayah
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('penghasilan_ayah');
            $table->text('alamat_ayah');
            $table->string('kontak_ayah');
            
            // Data ibu
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('penghasilan_ibu');
            $table->text('alamat_ibu');
            $table->string('kontak_ibu');
            
            // Status orang tua
            $table->enum('status_orang_tua', ['Ayah dan Ibu', 'Hanya Ayah', 'Hanya Ibu', 'Tidak Keduanya']);
            
            // Data wali
            $table->enum('wali_penanggung_jawab', ['Ayah', 'Ibu', 'Lainnya']);
            $table->string('nama_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('kontak_wali')->nullable();
            
            // Upload file
            $table->string('pas_foto_path')->nullable();
            $table->string('bukti_transfer_path')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
