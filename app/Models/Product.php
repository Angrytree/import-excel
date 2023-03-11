<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['manufacturer', 'code', 'name', 'description', 'price', 'warranty', 'availability'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
