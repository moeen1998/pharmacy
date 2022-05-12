<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParshaseDrug extends Model
{
    use HasFactory;
    protected $fillable = [
        'parshase_id',
        'drug_name',
        'qty',
        'price',
        'total',
        'disc',
    ];
}
