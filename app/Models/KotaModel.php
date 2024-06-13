<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KotaModel extends Model
{
    use HasFactory;

    protected $table = 'regencies';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
