<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Carbon\Carbon;

class Size extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Agar table me timestamps use nahi ho rahe to true/false set kar sakte ho
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes');
    }

    // Agar future me timestamps use karna ho
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getCreatedAtAttribute($value)
    {
        // Agar value null hai to null return kare, warna format kare
        return $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    // Naya record create karte waqt agar timestamps chahiye to
    protected static function booted()
    {
        static::creating(function ($size) {
            $size->created_at = $size->created_at ?? Carbon::now();
            $size->updated_at = $size->updated_at ?? Carbon::now();
        });
    }
}
