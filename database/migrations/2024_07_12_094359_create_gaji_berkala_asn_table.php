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
        Schema::create('gaji_berkala_asn', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('jenis_kelamin_id')->constrained('jenis_kelamin');
            $table->foreignId('golongan_lama_id')->nullable()->constrained('golongan')->cascadeOnDelete();
            $table->foreignId('golongan_baru_id')->nullable()->constrained('golongan')->cascadeOnDelete();
            
            $table->string('nama');
            $table->string('nip')->unique();
            $table->string('karpeg')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('kesatuan')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tmt_cpns')->nullable();
            $table->date('tmt_golongan')->nullable();

            $table->string('skep_lama')->nullable();
            $table->date('tmt_skep_lama')->nullable();
            $table->integer('tahun_mks_lama')->nullable();
            $table->integer('bulan_mks_lama')->nullable();
            $table->integer('tahun_mkg_lama')->nullable();
            $table->integer('bulan_mkg_lama')->nullable();
            $table->decimal('gaji_pokok_lama', total: 12, places: 0)->nullable();
            $table->date('tmt_kgb_lama')->nullable();
            $table->date('tmt_kgb_yad_lama')->nullable();
            
            $table->string('skep_baru')->nullable();
            $table->date('tmt_skep_baru')->nullable();
            $table->integer('tahun_mks_baru')->nullable();
            $table->integer('bulan_mks_baru')->nullable();
            $table->integer('tahun_mkg_baru')->nullable();
            $table->integer('bulan_mkg_baru')->nullable();
            $table->decimal('gaji_pokok_baru', total: 12, places: 0)->nullable();
            $table->date('tmt_kgb_baru')->nullable();
            $table->date('tmt_kgb_yad_baru')->nullable();

            $table->longText('keterangan')->nullable();
            $table->date('tanggal_terbit')->nullable();

            $table->softDeletes('deleted_at', precision: 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_berkala_asn');
    }
};
