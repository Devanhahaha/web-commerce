<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pulsa extends Model implements FeatureInterface {
    protected $table = 'pulsas'; 
    protected $guarded = [];

    public function getType() {
        return 'Pulsa';
    }
}