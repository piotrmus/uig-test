<?php
/**
 * Created by PhpStorm.
 * User: Piotr Musial
 * Date: 2019-02-28
 * Time: 12:54
 */

namespace Tests;

use \App\Queue\Queue_Object;

class Queue_ObjectTest extends \PHPUnit\Framework\TestCase
{

    public function testCreateQueue_Object()
    {
        $queueObject = new Queue_Object("Test task", 7);
        $this->assertInstanceOf(Queue_Object::class, $queueObject);
    }

    public function testTooHighPrioritySet()
    {
        $queueObject = new Queue_Object("Too High priority", 15);
        $this->assertEquals($queueObject->getPriority(), 10);
    }

    public function testTooLowPrioritySet()
    {
        $queueObject = new Queue_Object("Too High priority", 15);
        $this->assertEquals($queueObject->getPriority(), 10);
    }

}