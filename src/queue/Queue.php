<?php
/**
 * Created by PhpStorm.
 * User: Piotr Musial
 * Date: 2019-02-28
 * Time: 12:53
 */
namespace App\Queue;

class Queue implements \Iterator, \Countable, \Serializable
{
    private $currentKey = 0;

    private $items = [];

    public function add(Queue_Object $item)
    {
        $this->items[] = $item;
        $this->sortItems();
    }

    public function compare(Queue_Object $a, Queue_Object $b)
    {
        if ($a->getPriority() == $b->getPriority()) {
            return 0;
        }
        return ($a->getPriority() < $b->getPriority()) ? 1 : -1;
    }

    private function sortItems()
    {
        uasort($this->items, [$this, 'compare']);
        $this->items = array_values($this->items);
    }

    function rewind()
    {
        reset($this->items);
    }

    function current()
    {
        return current($this->items);
    }

    function key()
    {
        return key($this->items);
    }

    function next()
    {
        next($this->items);
    }

    function valid()
    {
        return key($this->items) !== null;
    }

    public function count()
    {
        return count($this->items);
    }

    public function toArray()
    {
        return $this->items;
    }

    /**
     * @param $paramName
     * @return int
     * @throws \Exception
     */
    private function getKeyFromParamName($paramName)
    {
        if (substr($paramName, 0, 4) == "elem") {
            $key = (int)substr($paramName, 4);
            return $key;
        }
        throw new \Exception("Wrong parameter");
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        $key = $this->getKeyFromParamName($name);
        if ($this->keyExist($key)) {
            return $this->getItem($key);
        }
        throw new \Exception("Elem $key not exist");
    }

    /**
     * @param $name
     * @return bool
     * @throws \Exception
     */
    public function __isset($name)
    {
        $key = $this->getKeyFromParamName($name);
        return $this->keyExist($key);
    }

    /**
     * @param $name
     * @throws \Exception
     */
    public function __unset($name)
    {
        $key = $this->getKeyFromParamName($name);
        if (!$this->keyExist($key)) {
            throw new \Exception("Elem $key not exist");
        }
        $this->deleteItem($key);
    }


    public function keyExist($key)
    {
        return isset($this->items[$key - 1]);
    }

    public function getItem($key)
    {
        return $this->items[$key - 1];
    }

    public function deleteItem($key)
    {
        if ($this->currentKey == $key) {
            $this->next();
        }
        unset($this->items[$key - 1]);
        $this->sortItems();
    }

    public function __call($name, $arguments)
    {
        if (!method_exists($this, $name)) {
            foreach ($this as $item) {
                call_user_func_array([$item, $name], $arguments);
            }
        }
    }

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        $key = $this->getKeyFromParamName($name);
        if (!$this->keyExist($key)) {
            throw new \Exception("Unsupported");
        }
        $this->items[$key - 1] = $value;
        $this->sortItems();
    }

    public function serialize()
    {
        return serialize($this->items);
    }

    public function unserialize($serialized)
    {
        $this->items  = unserialize($serialized);
    }
}
