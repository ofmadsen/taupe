<?php
namespace Taupe;

use ReflectionClass;
use Taupe\BlueprintInterface;
use Taupe\Container;
use Taupe\Exception\BlueprintMissingInterface;
use Taupe\Reflector;

/**
 * Factory class for instantiating objects.
 *
 * This factory is used for object instantiation during the application flow. A range of bindings may have been set
 * beforehand using the Container class. These bindings will be used to determine what class to instantiate.
 *
 * @author Oliver Finn Madsen <mail@ofmadsen.com>
 */
class Instantiator
{
    /** @var Container */
    private $container;

    /** @var Reflector */
    private $reflector;

    /** @var mixed[] */
    private $instances = [];

    /**
     * Constructor.
     *
     * Create an instance of the Reflector class, set both the injected Container and itself to be singleton in the
     * Container class, as well as setting a reference to this Instantiator instance in the Blueprint class.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->reflector = new Reflector();

        $this->container->instance(Instantiator::class, $this);
        $this->container->instance(Container::class, $container);
    }

    /**
     * Create a class.
     *
     * The simple flow is for classes where no binding has been set, otherwise a Binding object is used to perform the
     * necessary steps to create the desired class instance. Singleton instances are stored under the binding target,
     * not the source, since the target is used to create the instance from - if said binding is not a blueprint.
     *
     * @param string $class
     *
     * @return mixed
     */
    public function create($class)
    {
        $binding = $this->container->get($class);

        if (!$binding) {
            return $this->createFromClass($class);
        }

        // The instance can simply be returned as instance bindings are singletons
        if ($binding->instance) {
            return $binding->instance;
        }

        // For singletons that have been instantiated before - it can be returned
        if ($binding->singleton && isset($this->instances[$binding->target])) {
            return $this->instances[$binding->target];
        }

        if ($binding->blueprint) {
            $instance = $this->createFromBlueprint($binding->blueprint);
        } else {
            $instance = $this->createFromClass($binding->target);
        }

        if ($binding->singleton) {
            $this->instances[$binding->target] = $instance;
        }

        return $instance;
    }

    /**
     * Call method on class.
     *
     * The class is instantiated, the method class dependencies are resolved and any provided arguments are appended.
     * Optional scalar values are supported as well.
     *
     * @param string $class
     * @param string $method
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public function call($class, $method, ...$arguments)
    {
        $dependencies = $this->reflector->getMethodDependencies($class, $method, count($arguments));

        foreach (array_reverse($dependencies) as $dependency) {
            array_unshift($arguments, $this->create($dependency));
        }

        return $this->create($class)->$method(...$arguments);
    }

    /**
     * Create instance from blueprint.
     *
     * @param string $blueprint
     *
     * @throws UnusableBlueprint
     *
     * @return mixed
     */
    private function createFromBlueprint($blueprint)
    {
        $blueprint = $this->createFromClass($blueprint);

        if ($blueprint instanceof BlueprintInterface) {
            return $blueprint->build();
        }

        $blueprint = get_class($blueprint);
        $interface = BlueprintInterface::class;

        throw new BlueprintMissingInterface("{$blueprint} must implement {$interface}");
    }

    /**
     * Create instance from class.
     *
     * @param string $class
     *
     * @return mixed
     */
    private function createFromClass($class)
    {
        $dependencies = $this->reflector->getConstructorDependencies($class);

        $arguments = [];
        foreach ($dependencies as $dependency) {
            $arguments[] = $this->create($dependency);
        }

        return new $class(...$arguments);
    }
}
