<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class place extends Model
{
    use HasFactory;
    protected $fillable = [
        'place',
    ];
    public function drugs()
    {
        return $this->hasMany(Drug::class);
    }
}
