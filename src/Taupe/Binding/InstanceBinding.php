<?php
namespace Taupe\Binding;

use Taupe\Binding\Binding;

/**
 * Instance binding container.
 *
 * @author Oliver Finn Madsen <mail@ofmadsen.com>
 */
class InstanceBinding extends Binding
{
    /**
     * Constructor.
     *
     * Get the instance class for the target and set it to be a singleton as the source points to that instance.
     *
     * @param mixed $instance
     */
    public function __construct($instance)
    {
        $this->target = get_class($instance);
        $this->instance = $instance;
        $this->singleton = true;
    }
}
