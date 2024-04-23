<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_barcode',
        'product_qty',
        'product_price',
        'product_category',
        'product_detail',
        'product_image',
        'product_status',

    ];
}
