<?php
namespace Test\App\Dependency;

use stdClass;
use Test\App\Dependency\SingleClassDependency;
use Test\App\DependencyInterface;

class MethodDependency
{
    public function none()
    {
        return true;
    }

    public function scalar($value)
    {
        return $value;
    }

    public function optional(stdClass $class = null)
    {
        return $class;
    }

    public function single(SingleClassDependency $class)
    {
        return $class;
    }

    public function multiple(SingleClassDependency $class, $value)
    {
        return [$class, $value];
    }

    public function various(DependencyInterface $class, $value, $optional = null)
    {
        return [$class, $value, $optional];
    }
}
