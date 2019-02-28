<?php
/**
 * Created by PhpStorm.
 * User: Piotr Musial
 * Date: 2019-02-28
 * Time: 12:53
 */

namespace App\Queue;

class Queue_Object implements \Serializable
{

    private $taskName;
    private $priority;

    const MIN_PRIORITY = 0;
    const MAX_PRIORITY = 10;

    public function __construct(string $taskName, int $priority)
    {
        $this->taskName = $taskName;
        $this->setPriority($priority);
    }

    public function setPriority(int $priority)
    {
        if ($priority < self::MIN_PRIORITY) {
            $this->priority = self::MIN_PRIORITY;
        } else if ($priority > self::MAX_PRIORITY) {
            $this->priority = self::MAX_PRIORITY;
        } else {
            $this->priority = $priority;
        }
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getTaskName()
    {
        return $this->taskName;
    }

    public function printDescription()
    {
        printf("Name: %s Priority: %d \n", $this->getTaskName(), $this->getPriority());
    }

    public function serialize()
    {
        return serialize([$this->getTaskName(), $this->getPriority()]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->taskName = $data[0];
        $this->setPriority($data[1]);
    }
}
