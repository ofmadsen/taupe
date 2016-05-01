<?php
namespace Test;

use PHPUnit_Framework_TestCase as TestCase;
use Test\App\DependencyInterface;
use Test\App\Dependency\InterfaceDependency;
use Test\App\Dependency\MultipleClassDependency;
use Test\App\Dependency\OptionalScalarDependency;
use Test\App\Dependency\SingleClassDependency;
use Test\App\EmptyConstructor;
use Test\SetUpTrait;

class ConstructorDependencyTest extends TestCase
{
    use SetUpTrait;

    public function testCreateClassWithEmptyConstructor()
    {
        $instance = $this->instantiator->create(EmptyConstructor::class);
        $this->assertInstanceOf(EmptyConstructor::class, $instance);
    }

    public function testCreateClassWithSingleClassDependency()
    {
        $instance = $this->instantiator->create(SingleClassDependency::class);

        $this->assertInstanceOf(SingleClassDependency::class, $instance);
        $this->assertInstanceOf(EmptyConstructor::class, $instance->empty);
    }

    public function testCreateClassWithMultipleClassDependency()
    {
        $instance = $this->instantiator->create(MultipleClassDependency::class);

        $this->assertInstanceOf(MultipleClassDependency::class, $instance);
        $this->assertInstanceOf(EmptyConstructor::class, $instance->empty);

        $this->assertInstanceOf(SingleClassDependency::class, $instance->single);
        $this->assertInstanceOf(EmptyConstructor::class, $instance->single->empty);

        $this->assertNotSame($instance->empty, $instance->single->empty);
    }

    public function testCreateClassWithSingletonDependency()
    {
        $this->container->singleton(EmptyConstructor::class);

        $instance1 = $this->instantiator->create(SingleClassDependency::class);
        $instance2 = $this->instantiator->create(SingleClassDependency::class);

        $this->assertNotSame($instance1, $instance2);
        $this->assertSame($instance1->empty, $instance2->empty);
    }

    public function testCreateClassWithInterfaceDependency()
    {
        $this->container->bind(DependencyInterface::class, EmptyConstructor::class);

        $instance = $this->instantiator->create(InterfaceDependency::class);

        $this->assertInstanceOf(InterfaceDependency::class, $instance);
        $this->assertInstanceOf(EmptyConstructor::class, $instance->dependency);
    }

    public function testCreateClassWithInterfaceDependencyAsSingleton()
    {
        $this->container->bind(DependencyInterface::class, EmptyConstructor::class, true);

        $instance1 = $this->instantiator->create(InterfaceDependency::class);
        $instance2 = $this->instantiator->create(InterfaceDependency::class);

        $this->assertInstanceOf(InterfaceDependency::class, $instance1);
        $this->assertInstanceOf(EmptyConstructor::class, $instance1->dependency);

        $this->assertInstanceOf(InterfaceDependency::class, $instance2);
        $this->assertInstanceOf(EmptyConstructor::class, $instance2->dependency);

        $this->assertSame($instance1->dependency, $instance2->dependency);
    }

    public function testCreateClassWithOptionalScalarDependency()
    {
        $instance = $this->instantiator->create(OptionalScalarDependency::class);

        $this->assertNull($instance->class);

        $this->assertInternalType('array', $instance->array);
        $this->assertEmpty($instance->array);

        $this->assertInternalType('int', $instance->value);
        $this->assertSame(200, $instance->value);
    }
}
