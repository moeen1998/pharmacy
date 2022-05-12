<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parshase extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_name',
        'total',
    ];
    public function drugs()
    {
        return $this->hasMany(ParshaseDrug::class,'parshase_id','id');
    }
}
