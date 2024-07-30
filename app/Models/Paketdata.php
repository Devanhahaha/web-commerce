<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketData extends Model implements FeatureInterface {
    protected $table = 'paket_datas'; 
    protected $guarded = [];

    public function getType() {
        return 'Paket Data';
    }
}