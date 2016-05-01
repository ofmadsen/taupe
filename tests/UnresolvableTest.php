<?php
namespace Test;

use PHPUnit_Framework_TestCase as TestCase;
use Taupe\Exception\UnresolvableClass;
use Taupe\Exception\UnresolvableClassDependency;
use Taupe\Exception\UnresolvableDependency;
use Test\App\Unresolvable\ScalarValueDependency;
use Test\App\Unresolvable\StdClassDependency;
use Test\App\Unresolvable\UndefinedDependency;
use Test\SetUpTrait;
use UndefinedBlueprint;
use UndefinedClass;

class UnresolvableTest extends TestCase
{
    use SetUpTrait;

    public function testUndefinedClassThrowsException()
    {
        $class = UndefinedClass::class;

        $this->expectException(UnresolvableClass::class);
        $this->expectExceptionMessage("{$class}");

        $this->instantiator->create($class);
    }

    public function testCreateClassFromUnresolvableBlueprintThrowsException()
    {
        $blueprint = UndefinedBlueprint::class;

        $this->container->blueprint(SingleClassDependency::class, $blueprint);

        $this->expectException(UnresolvableClass::class);
        $this->expectExceptionMessage($blueprint);

        $this->instantiator->create(SingleClassDependency::class);
    }

    public function testUnresolvableScalarValueDependencyThrowsException()
    {
        $class = ScalarValueDependency::class;

        $this->expectException(UnresolvableDependency::class);
        $this->expectExceptionMessage("Parameter #0 [ <required> \$value ] in {$class}::__construct");

        $this->instantiator->create($class);
    }

    public function testUnresolvableStdClassDependencyThrowsException()
    {
        $class = StdClassDependency::class;

        $this->expectException(UnresolvableDependency::class);
        $this->expectExceptionMessage("Parameter #0 [ <required> stdClass \$value ] in {$class}::__construct");

        $this->instantiator->create($class);
    }

    public function testUndefinedDependencyThrowsException()
    {
        $class = UndefinedDependency::class;

        $this->expectException(UnresolvableClassDependency::class);
        $this->expectExceptionMessage("Parameter #0 [ <required> UndefinedClass \$class ] in {$class}::__construct");

        $this->instantiator->create($class);
    }
}
