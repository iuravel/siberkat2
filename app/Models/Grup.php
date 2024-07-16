<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grup extends Model
{
    use HasFactory;
    protected $table = 'grup';
    public $timestamps = false;
    protected $fillable = ['nama','uraian'];


}
