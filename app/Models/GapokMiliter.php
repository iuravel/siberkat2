<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GapokMiliter extends Model
{
    use HasFactory;
    protected $table = 'gapok_militer';
    public $timestamps = true;
    protected $fillable = ['pangkat_id','masa_kerja','gaji'];

    public function pangkat(): BelongsTo
    {
         return $this->belongsTo(Pangkat::class, foreignKey:'pangkat_id');
    }

    public function gajiBerkalaMiliter(): HasMany
    {
        return $this->hasMany(GajiBerkalaMiliter::class);
    }
}
