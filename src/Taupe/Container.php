<?php
namespace Taupe;

use Taupe\Binding\BlueprintBinding;
use Taupe\Binding\ClassBinding;
use Taupe\Binding\InstanceBinding;
use Taupe\Binding\SingletonBinding;

/**
 * Container for all bindings.
 *
 * @author Oliver Finn Madsen <mail@ofmadsen.com>
 */
class Container
{
    /** @var Binding[] */
    private $bindings = [];

    /**
     * Add a singleton binding.
     *
     * @param string $source
     */
    public function singleton($source)
    {
        $this->bindings[$source] = new SingletonBinding($source);
    }

    /**
     * Add binding from source to target.
     *
     * @param string $source
     * @param string $target
     * @param bool $singleton
     */
    public function bind($source, $target, $singleton = false)
    {
        $this->bindings[$source] = new ClassBinding($target, $singleton);
    }

    /**
     * Add instance binding.
     *
     * @param string $source
     * @param mixed $instance
     */
    public function instance($source, $instance)
    {
        $this->bindings[$source] = new InstanceBinding($instance);
    }

    /**
     * Add blueprint binding.
     *
     * @param string $source
     * @param string $blueprint
     * @param bool $singleton
     */
    public function blueprint($source, $blueprint, $singleton = false)
    {
        $this->bindings[$source] = new BlueprintBinding($source, $blueprint, $singleton);
    }

    /**
     * Get binding.
     *
     * @param string $source
     *
     * @return mixed
     */
    public function get($source)
    {
        if (isset($this->bindings[$source])) {
            return $this->bindings[$source];
        }

        return null;
    }
}
