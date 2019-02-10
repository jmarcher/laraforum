<?php
/**
 * Created by PhpStorm.
 * User: gordo
 * Date: 10.02.19
 * Time: 21:21
 */

namespace App\Services\Inspectors;


interface Inspector
{
    /**
     * @param string $text
     * @return void
     */
    public function detect(string $text): void;
}
