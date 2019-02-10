<?php

namespace App\Services;

use App\Services\Inspectors\InvalidKeywordInspector;
use App\Services\Inspectors\KeyHeldDown;

class SpamService
{

    protected $inspections = [
        InvalidKeywordInspector::class,
        KeyHeldDown::class
    ];

    public function detect(string $body): bool
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
