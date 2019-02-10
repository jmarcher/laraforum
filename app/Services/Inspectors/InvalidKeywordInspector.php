<?php
/**
 * Created by PhpStorm.
 * User: gordo
 * Date: 10.02.19
 * Time: 21:21
 */

namespace App\Services\Inspectors;


use Exception;

class InvalidKeywordInspector implements Inspector
{
    /**
     * @var array
     */
    protected $keywords = [
        'yahoo customer service',
    ];

    /**
     * @param string $body
     * @return void
     * @throws Exception
     */
    public function detect(string $body): void
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('The reply contains spam');
            }
        }
    }
}
