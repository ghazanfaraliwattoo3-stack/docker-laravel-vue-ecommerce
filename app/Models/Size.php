<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class Size extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function products()
    {
        return $this->belongsToMany(Product::class,'product_sizes');
    }

    protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
];

public function getCreatedAtAttribute($value)
{
    return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null;
}

public function getUpdatedAtAttribute($value)
{
    return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null;
}

}
