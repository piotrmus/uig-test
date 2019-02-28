<?php
/**
 * Created by PhpStorm.
 * User: Piotr Musial
 * Date: 2019-02-28
 * Time: 18:43
 */

namespace App\Tomula;

class TomUla
{
    const DIVISIBLE_BY_3_TEXT = "Tom";
    const DIVISIBLE_BY_5_TEXT = "Ula";

    public static function printList()
    {
        for ($i = 1; $i <= 100; $i++) {
            $isDivisibleBy3 = ($i % 3) === 0;
            $isDivisibleBy5 = ($i % 5) === 0;
            if ($isDivisibleBy5 && $isDivisibleBy3) {
                echo self::DIVISIBLE_BY_3_TEXT . self::DIVISIBLE_BY_5_TEXT;
            } else if ($isDivisibleBy3) {
                echo self::DIVISIBLE_BY_3_TEXT;
            } else if ($isDivisibleBy5) {
                echo self::DIVISIBLE_BY_5_TEXT;
            } else {
                echo $i;
            }
            echo "\n";
        }
    }
}