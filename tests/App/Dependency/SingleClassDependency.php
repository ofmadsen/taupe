<?php
namespace Test\App\Dependency;

use Test\App\EmptyConstructor;

class SingleClassDependency
{
    public $empty;

    public function __construct(EmptyConstructor $empty)
    {
        $this->empty = $empty;
    }
}
