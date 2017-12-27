<?php
class Collection implements ArrayAccess, Iterator, Countable
{
    private $container = [];
    private $point     = 0;

    public function __construct($data = [])
    {
        $this->container = $data;
        $this->point     = 0;
    }

    /**
     * 获取对象属性
     * @param  [type] $name           [description]
     * @return [type] [description]
     */
    public function __get($name)
    {
        if (is_array($this[$name])) {
            return new self($this[$name]);
        } else {
            return $this[$name];
        }
    }

    /**
     * 设置对象属性
     * @param [type] $name  [description]
     * @param string $value [description]
     */
    public function __set($name, $value = '')
    {
        $this->container[$name] = $value;
    }

    /**
     * 将对象转换为数组
     * @return [type] [description]
     */
    public function toArray()
    {
        $arr = (array) $this;
        return current($arr);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }

    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function current()
    {
        $key = array_keys($this->container)[$this->point];
        return new self($this[$key]);
    }

    public function key()
    {
        return array_keys($this->container)[$this->point];
    }

    public function next()
    {
        ++$this->point;
    }

    public function rewind()
    {
        $this->point = 0;
    }

    public function valid()
    {
        return count($this->container) > $this->point;
    }

    public function count()
    {
        return count($this->container);
    }
}

$arr = [
    'lesson'  => [
        'one' => 'english',
        'two' => 'chinese',
    ],
    'teacher' => [
        'one'   => 'zhang',
        'two'   => 'chen',
        'three' => 'huang',
    ],
];

$std = new Collection($arr);

//数组转为对象[数组]集合类
$arr = [
    'lesson'  => [
        'one' => 'english',
        'two' => 'chinese',
    ],
    'teacher' => [
        'one'   => 'zhang',
        'two'   => 'chen',
        'three' => 'huang',
    ],
];

$std = new Collection($arr);
var_dump($std->lesson->one);
var_dump($std->teacher->toArray());
$std->lesson->three = 'math';
var_dump($std->lesson->four);
var_dump($std['lesson']);
var_dump($std->lesson['one']);
//测试循环
foreach ($std as $item) {
    var_dump(count($item));
    var_dump($item->toArray());
    var_dump($item->one);
    var_dump($item->three);
}
