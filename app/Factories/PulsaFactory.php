<?php
namespace App\Factories;

use App\Models\Pulsa;

class PulsaFactory implements FeatureFactoryInterface {
    public function createFeature(array $data) {
        return Pulsa::create($data);
    }
}