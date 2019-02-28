<?php
/**
 * Created by PhpStorm.
 * User: Piotr Musial
 * Date: 2019-02-28
 * Time: 18:44
 */

namespace Test;

use App\Tomula\TomUla;
use PHPUnit\Framework\TestCase;

class TomUlaTest extends TestCase
{
    public function testPrintList()
    {
        ob_start();
        TomUla::printList();
        $result = ob_get_clean();

        $this->assertContains("1\n2\nTom\n4\nUla\nTom", $result);
    }
}