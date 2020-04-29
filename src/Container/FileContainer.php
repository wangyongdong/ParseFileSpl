<?php

namespace ParseFileSpl\Container;

/**
 * Class FileContainer
 * @package ParseFileSpl\Container
 */
class FileContainer
{
    /**
     * 存放闭包函数
     * @var
     */
    protected $binds;

    /**
     * 存放实例对象
     * @var
     */
    protected $instances;

    /**
     * bind是向容器中绑定服务对象
     * 在bind方法中需要传入一个 concrete 我们可以传入一个实例对象或者是一个闭包函数
     * @param $abstract
     * @param $concreate 闭包函数 或实例对象
     */
    public function bind($abstract, $concreate)
    {
        if ($concreate instanceof Closure) {
            // 判断是否是闭包匿名类
            $this->binds[$abstract] = $concreate;
        } else {
            $this->instances[$abstract] = $concreate;
        }
    }

    /**
     * make是从容器中取出对象
     * make方法就从容器中出去方法。里面首先判断了instances变量中是否有当前以及存在的服务对象，如果有直接返回。
     * 如果没有那么会通过 call_user_func_array返回一个对象。call_user_func_array的使用可以查看
     * @param $abstract
     * @param array $parameters
     * @return mixed
     */
    public function make($abstract, $parameters = [])
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        // 处理闭包匿名类
        array_unshift($parameters, $this);
        return call_user_func_array($this->binds[$abstract], $parameters);
    }
}
