<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'description',
        'tags',
        'categories_id',
    ];

    //NOTE : kalau relasi nya many(banyak) maka gunakan ies dibelakang
    public function galleries()
    {
        //digunakan untuk menyambungkan antara data product dengan gallery
        return $this->hasMany(ProductGallery::class, 'produtcs_id', 'id');
    }
    public function category()
    {
        //kebalikann  dari relasi diatas
        return  $this->belongsTo(ProductCategory::class, 'categories_id', 'id');
    }
}
