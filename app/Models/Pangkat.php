<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pangkat extends Model
{
    use HasFactory;
    protected $table = 'pangkat';
    public $timestamps = false;
    protected $fillable = ['nama','uraian','grup_id'];

    public function grup(): BelongsTo
    {
         return $this->belongsTo(Grup::class, foreignKey:'grup_id');
    }
    // public function gajiBerkalaMiliter(): HasMany
    // {
    //     return $this->hasMany(GajiBerkalaMiliter::class);
    // }
}
