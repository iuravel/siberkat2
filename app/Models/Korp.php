<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Korp extends Model
{
    use HasFactory;
    protected $table = 'korp';
    public $timestamps = false;
    protected $fillable = ['nama','uraian'];
    public function pangkat(): BelongsTo
    {
        return $this->belongsTo(Pangkat::class);
    }
    public function gajiBerkalaMiliter(): HasMany
    {
        return $this->hasMany(GajiBerkalaMiliter::class);
    }
}
