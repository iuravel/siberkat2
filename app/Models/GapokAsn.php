<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GapokAsn extends Model
{
    use HasFactory;
    protected $table = 'gapok_asn';
    public $timestamps = true;
    protected $fillable = ['golongan_id','masa_kerja','gaji'];

    public function golongan(): BelongsTo
    {
         return $this->belongsTo(Golongan::class, foreignKey:'golongan_id');
    }
}
