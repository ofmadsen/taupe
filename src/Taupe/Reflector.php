<?php
namespace Taupe;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Taupe\Exception\UndefinedMethod;
use Taupe\Exception\UnresolvableClass;
use Taupe\Exception\UnresolvableClassDependency;
use Taupe\Exception\UnresolvableDependency;

/**
 * Reflection wrapper class.
 *
 * Used to get constructor or method dependencies.
 *
 * @author Oliver Finn Madsen <mail@ofmadsen.com>
 */
class Reflector
{
    /** @var ReflectionClass[] */
    private $reflections = [];

    /** @var mixed[] */
    private $dependencies = [];

    /**
     * Get constructor dependencies.
     *
     * @param string $class
     *
     * @return mixed[]
     */
    public function getConstructorDependencies($class)
    {
        $constructor = $this->reflect($class)->getConstructor();

        if (!$constructor) {
            return [];
        }

        return $this->getDependencies($class, $constructor);
    }

    /**
     * Get metod dependencies.
     *
     * Provide a count of the manually injected arguments.
     *
     * @param string $class
     * @param string $method
     * @param int $count
     *
     * @throws UndefinedMethod
     *
     * @return mixed[]
     */
    public function getMethodDependencies($class, $method, $count = 0)
    {
        try {
            $method = $this->reflect($class)->getMethod($method);
        } catch (ReflectionException $exception) {
            throw new UndefinedMethod("{$class}::{$method}");
        }

        return $this->getDependencies($class, $method, $count);
    }

    /**
     * Reflect a class.
     *
     * @param string $class
     *
     * @throws UnresolvableClass
     *
     * @return ReflectionClass
     */
    private function reflect($class)
    {
        if (!isset($this->reflections[$class])) {
            try {
                $this->reflections[$class] = new ReflectionClass($class);
            } catch (ReflectionException $exception) {
                throw new UnresolvableClass($class);
            }
        }

        return $this->reflections[$class];
    }

    /**
     * Get dependencies given class and method.
     *
     * Loops through the dependencies for the method, if the dependency is a class it is added to the list as it can
     * be resolved (interfaces must be binded to a concrete class first though). If the dependency is a scalar it must
     * have an optional value or must manually provide a value.
     *
     * @param string $class
     * @param ReflectionMethod $method
     * @param int $count
     *
     * @throws UnresolvableClassDependency
     * @throws UnresolvableDependency
     *
     * @return mixed[]
     */
    private function getDependencies($class, ReflectionMethod $method, $count = 0)
    {
        $identifier = "{$class}::{$method->name}";

        if (isset($this->dependencies[$identifier])) {
            return $this->dependencies[$identifier];
        }

        $dependencies = [];
        foreach ($method->getParameters() as $index => $parameter) {

            try {
                $class = $parameter->getClass();
            } catch (ReflectionException $exception) {
                throw new UnresolvableClassDependency("{$parameter} in {$identifier}");
            }

            if ($class && $class->getName() !== 'stdClass') {
                $dependencies[$index] = $class->getName();
                continue;
            }

            // The paramter is a scalar, but if the class dependencies and manually provided values are equal to or
            // more than the number of required parameters, then the rest of the parameters are ignored.
            if ($count && count($dependencies) + $count >= $method->getNumberOfRequiredParameters()) {
                break;
            }

            if ($parameter->isDefaultValueAvailable()) {
                continue;
            }

            throw new UnresolvableDependency("{$parameter} in {$identifier}");
        }

        $this->dependencies[$identifier] = $dependencies;
        return $dependencies;
    }
}
