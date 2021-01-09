<?php

namespace App\Http\Tools;

class Vip
{
    private $name;
    private $age;
    private $sex;

    function __construct($name = "", $age = 10, $sex = 1)
    {
        $this->name = $name;
        $this->age  = $age;
        $this->sex  = $sex;
    }

    /**
     * 在类中添加__get()方法，在直接获取属性值时自动调用一次，以属性名作为参数传入并处理
     * @param $propertyName
     * @return int
     */
    public function __get($propertyName)
    {
        if ($propertyName == "age") {
            if ($this->age > 30) {
                return $this->age - 10;
            } else {
                return $this->$propertyName;
            }
        } else {
            return $this->$propertyName;
        }
    }

    public function __set($propertyName, $val)
    {
        $this->$propertyName = $val;
    }

    public function __isset($propertyName)
    {
        if ($propertyName == "age") {
            $this->$propertyName = $this->$propertyName + 100;
        } elseif ($propertyName == "name") {
            $this->$propertyName = $this->$propertyName . '?????';
        }
    }

    public function __unset($propertyName)
    {
        if ($propertyName == "sex") {
            $this->$propertyName = 0;
        } elseif ($propertyName == "name") {
            $this->$propertyName = $this->$propertyName . '?????不给你删除。';
        }
    }

    public function __toString()
    {
        return '!@$!#$!%!@!!$%1%!&(^^%^##!';
    }

    public function setAge($age)
    {
        $this->age = $age;
    }
}