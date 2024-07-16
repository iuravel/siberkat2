<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JenisKelamin extends Model
{
    use HasFactory;
    protected $table = 'jenis_kelamin';
    public $timestamps = false;
    protected $fillable = ['nama','singkatan'];

    public function gajiBerkalaMiliter(): HasMany
    {
        return $this->hasMany(GajiBerkalaMiliter::class);
    }
}
