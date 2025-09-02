<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
        });

        $pendaftarans = \App\Models\Pendaftaran::all();
        foreach ($pendaftarans as $pendaftaran) {
            $pendaftaran->uuid = Str::uuid();
            $pendaftaran->save();
        }
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
