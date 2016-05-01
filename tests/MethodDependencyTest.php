<?php
namespace Test;

use PHPUnit_Framework_TestCase as TestCase;
use stdClass;
use Taupe\Exception\UndefinedMethod;
use Test\App\DependencyInterface;
use Test\App\Dependency\MethodDependency;
use Test\App\Dependency\SingleClassDependency;
use Test\App\EmptyConstructor;
use Test\SetUpTrait;

class MethodDependencyTest extends TestCase
{
    use SetUpTrait;

    public function testCallMethod()
    {
        $result = $this->instantiator->call(MethodDependency::class, 'none');
        $this->assertTrue($result);
    }

    public function testCallMethodWithScalar()
    {
        $result = $this->instantiator->call(MethodDependency::class, 'scalar', 200);
        $this->assertSame(200, $result);
    }

    public function testCallMethodWithDefinedOptional()
    {
        $class = new stdClass();

        $result = $this->instantiator->call(MethodDependency::class, 'optional', $class);
        $this->assertSame($class, $result);
    }

    public function testCallMethodWithUndefinedOptional()
    {
        $result = $this->instantiator->call(MethodDependency::class, 'optional');
        $this->assertNull($result);
    }

    public function testCallMethodWithClass()
    {
        $result = $this->instantiator->call(MethodDependency::class, 'single');
        $this->assertInstanceOf(SingleClassDependency::class, $result);
    }

    public function testCallMethodWithClassAndScalar()
    {
        $result = $this->instantiator->call(MethodDependency::class, 'multiple', 200);

        $this->assertInstanceOf(SingleClassDependency::class, $result[0]);
        $this->assertSame(200, $result[1]);
    }

    public function testCallMethodWithInterfaceBindAndOptional()
    {
        $this->container->bind(DependencyInterface::class, EmptyConstructor::class);

        $result = $this->instantiator->call(MethodDependency::class, 'various', 200);

        $this->assertInstanceOf(EmptyConstructor::class, $result[0]);
        $this->assertSame(200, $result[1]);
        $this->assertNull($result[2]);
    }

    public function testCallMethodWithInterfaceBind()
    {
        $this->container->bind(DependencyInterface::class, EmptyConstructor::class);
        $class = new stdClass();

        $result = $this->instantiator->call(MethodDependency::class, 'various', 200, $class);

        $this->assertInstanceOf(EmptyConstructor::class, $result[0]);
        $this->assertSame(200, $result[1]);
        $this->assertSame($class, $result[2]);
    }

    public function testCallUndefinedMethodThrowsException()
    {
        $class = MethodDependency::class;
        $method = 'undefined';

        $this->expectException(UndefinedMethod::class);
        $this->expectExceptionMessage("{$class}::{$method}");

        $this->instantiator->call($class, $method);
    }
}
