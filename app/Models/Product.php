<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Size;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];
    
 protected $appends=['imagePath'];
    protected function getImagePathAttribute()
    {
        return 
           asset('uploads/products/large/'.$this->image);
        
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class,'product_sizes');
    }
    
}
