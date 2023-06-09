<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_detail extends Model
{
    use HasFactory;

    protected $fillable = ['size', 'material', 'brand', 'id_prod_fk'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'id_prod_fk', 'id');
    }
}
