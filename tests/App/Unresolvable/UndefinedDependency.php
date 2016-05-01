<?php
namespace Test\App\Unresolvable;

use UndefinedClass;

class UndefinedDependency
{
    public $class;

    public function __construct(UndefinedClass $class)
    {
        $this->class = $class;
    }
}
