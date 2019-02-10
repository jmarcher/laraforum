<?php
/**
 * Created by PhpStorm.
 * User: gordo
 * Date: 10.02.19
 * Time: 21:27
 */

namespace App\Services\Inspectors;


use Exception;

class KeyHeldDown implements Inspector
{

    /**
     * @param string $body
     * @return void
     * @throws Exception
     */
    public function detect(string $body): void
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new Exception('The reply contains spam');
        }
    }
}
