<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'disc',
        'avilablesunit',
        'smallprice',
        'packet',
        'min',
        'short',
        'place_name',
        'category_name',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function place()
    {
        return $this->belongsTo(Place::class);
    }





}
