<?php
namespace Test\App\Unresolvable;

use UndefinedClass;

class UndefinedDependency
{
    public function __construct(UndefinedClass $class)
    {
    }
}
