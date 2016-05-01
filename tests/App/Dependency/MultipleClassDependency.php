<?php
namespace Test\App\Dependency;

use Test\App\EmptyConstructor;
use Test\App\Dependency\SingleClassDependency;

class MultipleClassDependency
{
    public $empty;
    public $single;

    public function __construct(EmptyConstructor $empty, SingleClassDependency $single)
    {
        $this->empty = $empty;
        $this->single = $single;
    }
}
