<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GajiBerkalaMiliter extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gaji_berkala_militer';
    public $timestamps = true;
    protected $fillable = [
        'user_id','pangkat_lama_id','pangkat_baru_id','korp_id','jenis_kelamin_id',
        'nama','nrp','is_kowad','jabatan','kesatuan', 'tanggal_lahir','tmt_tni','tmt_pangkat',
        'tahun_mks_lama','bulan_mks_lama','tahun_mkg_lama','bulan_mkg_lama','gaji_pokok_lama','tmt_kgb_lama','tmt_kgb_yad_lama',
        'tahun_mks_baru','bulan_mks_baru','tahun_mkg_baru','bulan_mkg_baru','gaji_pokok_baru','tmt_kgb_baru','tmt_kgb_yad_baru',
        'keterangan','tanggal_terbit','deleted_at',
    ];

    public function jenisKelamin(): BelongsTo
    {
        return $this->belongsTo(JenisKelamin::class, foreignKey:'jenis_kelamin_id');
    }
    public function pangkatLama(): BelongsTo
    {
        return $this->belongsTo(Pangkat::class, 'pangkat_lama_id');
    }
    public function pangkatBaru(): BelongsTo
    {
        return $this->belongsTo(Pangkat::class, 'pangkat_baru_id');
    }
    public function korp(): BelongsTo
    {
        return $this->belongsTo(Korp::class);
    }
    public function gapokMiliter(): BelongsToMany
    {
        return $this->belongsToMany(GapokMiliter::class);
    }
    
    public function getFullMksLamaAttribute()
    {
        //MKS LAMA
        $tahun = $this->tahun_mks_lama;
        $bulan = $this->bulan_mks_lama;
        return $tahun .''. $bulan;
    }
    public function getFullMkgLamaAttribute()
    {
        //MKG LAMA
        $tahun = $this->tahun_mkg_lama;
        $bulan = $this->bulan_mkg_lama;
        return $tahun .''. $bulan;
    }
    public function getFullMksBaruAttribute()
    {
        //MKS BARU
        $tahun = $this->tahun_mks_baru;
        $bulan = $this->bulan_mks_baru;
        return $tahun .''. $bulan;
    }
    public function getFullMkgBaruAttribute()
    {
        //MKG BARU
        $tahun = $this->tahun_mkg_baru;
        $bulan = $this->bulan_mkg_baru;
        return $tahun .''. $bulan;
    }
}
