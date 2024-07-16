<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('gaji_berkala_militer', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('jenis_kelamin_id')->constrained('jenis_kelamin')->cascadeOnDelete();
        //     $table->foreignId('pangkat_lama_id')->constrained('pangkat')->cascadeOnDelete();
        //     $table->foreignId('pangkat_baru_id')->constrained('pangkat')->cascadeOnDelete();
        //     $table->foreignId('korp_id')->constrained('korp')->cascadeOnDelete();
        //     $table->string('nama');
        //     $table->string('nrp')->unique();
        //     $table->boolean('is_kowad')->nullable()->default(0);
        //     $table->string('jabatan')->nullable();
        //     $table->date('tanggal_lahir')->nullable();
        //     $table->date('tmt_tni')->nullable();
        //     $table->date('tmt_pangkat')->nullable();

        //     $table->integer('tahun_mks_lama')->nullable();
        //     $table->integer('bulan_mks_lama')->nullable();
        //     $table->integer('tahun_mkg_lama')->nullable();
        //     $table->integer('bulan_mkg_lama')->nullable();
        //     $table->decimal('gaji_pokok_lama', total: 12, places: 2);
        //     $table->date('tmt_kgb_lama')->nullable();
        //     $table->date('tmt_kgb_yad_lama')->nullable();

        //     $table->integer('tahun_mks_baru')->nullable();
        //     $table->integer('bulan_mks_baru')->nullable();
        //     $table->integer('tahun_mkg_baru')->nullable();
        //     $table->integer('bulan_mkg_baru')->nullable();
        //     $table->decimal('gaji_pokok_baru', total: 12, places: 2);
        //     $table->date('tmt_kgb_baru')->nullable();
        //     $table->date('tmt_kgb_yad_baru')->nullable();

        //     $table->string('keterangan')->nullable();
        //     $table->date('tanggal_terbit')->nullable();

        //     $table->dateTime('deleted_at')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('gaji_berkala_militer');
    }
};
