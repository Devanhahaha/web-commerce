<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCust extends Model
{
    use HasFactory;
    protected $table = 'product_custs';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
