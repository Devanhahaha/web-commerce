<?php
namespace App\Factories;

use App\Models\PaketData;

class PaketDataFactory implements FeatureFactoryInterface {
    public function createFeature(array $data) {
        return PaketData::create($data);
    }
}