<?php

namespace App\Services;

class SpamService
{
    public function detect(string $body): bool
    {
        $this->detectInvalidKeywords($body);
        return false;
    }

    protected function detectInvalidKeywords(string $body)
    {
        $invalidKeywords = [
            'yahoo customer service',
        ];

        foreach ($invalidKeywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('The reply contains spam');
            }
        }
    }
}
