<?php
namespace Test\App\Dependency;

use Taupe\Container;

class ContainerDependency
{
    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
