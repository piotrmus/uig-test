<?php
/**
 * Created by PhpStorm.
 * User: Piotr Musial
 * Date: 2019-02-28
 * Time: 19:38
 */

namespace Test;


use App\Queue\Queue;
use App\Queue\Queue_Object;
use PHPUnit\Framework\TestCase;

class QueueTest extends TestCase
{
    public function testCreateQueue(){
        $queue = new Queue();

        $queue->add(new Queue_Object("One", 2));
        $queue->add(new Queue_Object("Two", 3));
        $queue->add(new Queue_Object("Three", 1));

        $this->assertInstanceOf(Queue::class, $queue);

        return $queue;
    }

    /**
     * @depends testCreateQueue
     * @param Queue $queue
     */
    public function testLoopPrint(Queue $queue)
    {
        $order = [];
        foreach ($queue as $item) {
            $order[] = $item->getTaskName();
        }

        $this->assertEquals($order, [
            'Two',
            'One',
            'Three'
        ]);

    }

    /**
     * @depends testCreateQueue
     * @param Queue $queue
     */
    public function testQueueCount(Queue $queue)
    {
        $this->assertEquals($queue->count(), 3);
    }

    /**
     * @depends testCreateQueue
     * @param Queue $queue
     */
    public function testQueueToArray(Queue $queue)
    {
        $this->assertEquals($queue->toArray(), [
            new Queue_Object("Two", 3),
            new Queue_Object("One", 2),
            new Queue_Object("Three", 1),
        ]);
    }

    public function testGetElemAsParameter()
    {
        $queue = new Queue();

        $task1 = new Queue_Object("One", 2);
        $queue->add($task1);
        $task2 = new Queue_Object("Two", 3);
        $queue->add($task2);
        $task3 = new Queue_Object("Three", 1);
        $queue->add($task3);

        $this->assertEquals($queue->elem3, $task3);
    }

    public function testElemExist()
    {
        $queue = new Queue();

        $task1 = new Queue_Object("One", 2);
        $queue->add($task1);
        $task2 = new Queue_Object("Two", 3);
        $queue->add($task2);
        $task3 = new Queue_Object("Three", 1);
        $queue->add($task3);

        $this->assertTrue(isset($queue->elem3));
        $this->assertFalse(isset($queue->elem5));
    }

    public function testDeleteItem()
    {

        $queue = new Queue();

        $task1 = new Queue_Object("One", 2);
        $queue->add($task1);
        $task2 = new Queue_Object("Two", 3);
        $queue->add($task2);
        $task3 = new Queue_Object("Three", 1);
        $queue->add($task3);

        $this->assertTrue(isset($queue->elem3));
        unset($queue->elem3);
        $this->assertFalse(isset($queue->elem3));

    }

    public function testQueueSetter()
    {

        $queue = new Queue();

        $task1 = new Queue_Object("One", 2);
        $queue->add($task1);
        $task2 = new Queue_Object("Two", 3);
        $queue->add($task2);
        $task3 = new Queue_Object("Three", 1);
        $queue->add($task3);

        $this->expectExceptionMessage("Unsupported");
        $queue->elem5 = new Queue_Object("Replace object", 1);

    }

    public function testCallFunctionOnQueueObjects()
    {
        $queue = new Queue();

        $task1 = new Queue_Object("One", 2);
        $queue->add($task1);
        $task2 = new Queue_Object("Two", 3);
        $queue->add($task2);
        $task3 = new Queue_Object("Three", 1);
        $queue->add($task3);

        $text = "";
        foreach ($queue as $item) {
            $text .= sprintf("Name: %s Priority: %d \n", $item->getTaskName(), $item->getPriority());;
        }

        ob_start();
        $queue->printDescription();
        $output = ob_get_clean();
        $this->assertEquals($output, $text);
    }

    public function testSerialization()
    {
        $queue = new Queue();

        $task1 = new Queue_Object("One", 2);
        $queue->add($task1);
        $task2 = new Queue_Object("Two", 3);
        $queue->add($task2);
        $task3 = new Queue_Object("Three", 1);
        $queue->add($task3);

        $serializedQueueTest = serialize($queue);

        $serializedString = 'C:15:"App\Queue\Queue":209:{a:3:{i:0;C:22:"App\Queue\Queue_Object":28:{a:2:{i:0;s:3:"Two";i:1;i:3;}}i:1;C:22:"App\Queue\Queue_Object":28:{a:2:{i:0;s:3:"One";i:1;i:2;}}i:2;C:22:"App\Queue\Queue_Object":30:{a:2:{i:0;s:5:"Three";i:1;i:1;}}}}';

        $this->assertEquals(
            $serializedString,
            (string)$serializedQueueTest);

        $this->assertEquals(unserialize($serializedString), $queue);
    }
}