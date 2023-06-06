<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['reference', 'name', 'description', 'purchase_price', 'sale_price', 'id_cat_fk', 'photo'];
}
