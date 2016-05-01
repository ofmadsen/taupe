<?php
namespace Test;

use PHPUnit_Framework_TestCase as TestCase;
use Test\App\Dependency\ContainerDependency;
use Test\App\Dependency\InstantiatorDependency;
use Test\SetUpTrait;

class InstantiatorTest extends TestCase
{
    use SetUpTrait;

    public function testContainerIsSingleton()
    {
        $instance = $this->instantiator->create(ContainerDependency::class);
        $this->assertSame($this->container, $instance->container);
    }

    public function testInstantiatorIsSingleton()
    {
        $instance = $this->instantiator->create(InstantiatorDependency::class);
        $this->assertSame($this->instantiator, $instance->instantiator);
    }
}
