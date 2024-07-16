<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SebastianBergmann\Type\VoidType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        self::createGrupTable();
        self::createGolonganTable();
        self::createPangkatTable();
        self::createKorpTable();
        self::createJenisKelaminTable();
        self::createGapokMiliter();
        self::createGapokAsn();
        self::createGajiBerkalaMiliter();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grup');
        Schema::dropIfExists('golongan');
        Schema::dropIfExists('pangkat');
        Schema::dropIfExists('korp');
        Schema::dropIfExists('jenis_kelamin');
        Schema::dropIfExists('gapok_militer');
        Schema::dropIfExists('gapok_asn');
        Schema::dropIfExists('personel_militer');
        Schema::dropIfExists('gaji_berkala_militer');
    }

    /**
     * Other Table.
    */
    public function createGrupTable(): void
    {
        Schema::create('grup', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('uraian')->nullable();
            $table->timestamps();
        });
    }
    public function createGolonganTable(): void
    {
        Schema::create('golongan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grup_id')->constrained('grup');
            $table->string('nama');
            $table->string('uraian')->nullable();
            $table->timestamps();
        });
    }
    public function createPangkatTable(): void
    {
        Schema::create('pangkat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grup_id')->constrained('grup');
            $table->string('nama');
            $table->string('uraian')->nullable();
            $table->timestamps();
        });
    }
    public function createKorpTable(): void
    {
        Schema::create('korp', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('uraian')->nullable();
            $table->timestamps();
        });
    }
    public function createJenisKelaminTable(): void
    {
        Schema::create('jenis_kelamin', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('singkatan')->nullable();
            $table->timestamps();
        });
    }
    public function createGapokMiliter(): void
    {
        Schema::create('gapok_militer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pangkat_id')->constrained('pangkat')->cascadeOnDelete();
            $table->string('masa_kerja')->nullable();
            $table->decimal('gaji', total: 12, places: 0)->nullable();
            $table->timestamps();
        });
    }
    public function createGapokAsn(): void
    {
        Schema::create('gapok_asn', function (Blueprint $table) {
            $table->id();
            $table->foreignId('golongan_id')->constrained('golongan')->cascadeOnDelete();
            $table->integer('masa_kerja')->nullable();
            $table->decimal('gaji', total: 12, places: 0)->nullable();
            $table->timestamps();
        });
    }
    public function createGajiBerkalaMiliter(): void
    {
        Schema::create('gaji_berkala_militer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('jenis_kelamin_id')->nullable()->constrained('jenis_kelamin');
            $table->foreignId('pangkat_lama_id')->nullable()->constrained('pangkat');
            $table->foreignId('pangkat_baru_id')->nullable()->constrained('pangkat');
            $table->foreignId('korp_id')->nullable()->constrained('korp');
            $table->string('nama')->nullable();
            $table->string('nrp')->nullable()->unique();
            $table->string('jabatan')->nullable();
            $table->string('kesatuan')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tmt_tni')->nullable();
            $table->date('tmt_pangkat')->nullable();

            $table->integer('tahun_mks_lama')->nullable();
            $table->integer('bulan_mks_lama')->nullable();
            $table->integer('tahun_mkg_lama')->nullable();
            $table->integer('bulan_mkg_lama')->nullable();
            $table->decimal('gaji_pokok_lama', total: 12, places: 0)->nullable();
            $table->date('tmt_kgb_lama')->nullable();
            $table->date('tmt_kgb_yad_lama')->nullable();

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
    
};
