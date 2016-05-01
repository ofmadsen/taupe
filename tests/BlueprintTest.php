<?php
namespace Test;

use PHPUnit_Framework_TestCase as TestCase;
use Taupe\BlueprintInterface;
use Taupe\Exception\BlueprintMissingInterface;
use Test\App\Blueprint\ScalarValueDependencyBlueprint;
use Test\App\Blueprint\SingleClassDependencyBlueprint;
use Test\App\Dependency\ScalarValueDependency;
use Test\App\Dependency\SingleClassDependency;
use Test\App\EmptyConstructor;
use Test\SetUpTrait;

class BlueprintTest extends TestCase
{
    use SetUpTrait;

    public function testCreateClassFromScalarValueBlueprint()
    {
        $this->container->blueprint(ScalarValueDependency::class, ScalarValueDependencyBlueprint::class);

        $instance = $this->instantiator->create(ScalarValueDependency::class);
        $this->assertSame(200, $instance->value);
    }

    public function testCreateClassFromSingleClassBlueprint()
    {
        $empty = new EmptyConstructor();

        $this->container->instance(EmptyConstructor::class, $empty);
        $this->container->blueprint(SingleClassDependency::class, SingleClassDependencyBlueprint::class);

        $instance = $this->instantiator->create(SingleClassDependency::class);
        $this->assertSame($empty, $instance->empty);
    }

    public function testCreateClassFromBlueprintMissingInterfaceThrowsException()
    {
        $this->expectException(BlueprintMissingInterface::class);
        $this->expectExceptionMessage(EmptyConstructor::class.' must implement '.BlueprintInterface::class);

        $this->container->blueprint(SingleClassDependency::class, EmptyConstructor::class);

        $this->instantiator->create(SingleClassDependency::class);
    }
}
