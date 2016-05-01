<?php
namespace Test\App\Dependency;

use Test\App\DependencyInterface;

class InterfaceDependency
{
    public $dependency;

    public function __construct(DependencyInterface $dependency)
    {
        $this->dependency = $dependency;
    }
}
