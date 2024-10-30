<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksis';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pulsa()
    {
        return $this->hasOne(Pulsa::class);
    }

    public function paketdata()
    {
        return $this->hasOne(Paketdata::class);
    }

    public function bayartagihan()
    {
        return $this->hasOne(Bayartagihan::class);
    }

    public function services()
    {
        return $this->hasOne(Services::class);
    }

    public function productcust()
    {
        return $this->hasOne(ProductCust::class);
    }
}
