<?php
namespace Taupe\Binding;

use Taupe\Binding\Binding;

/**
 * Singleton binding container.
 *
 * @author Oliver Finn Madsen <mail@ofmadsen.com>
 */
class SingletonBinding extends Binding
{
    /**
     * Constructor.
     *
     * Defines the target to be the source as a singleton.
     *
     * @param string $source
     */
    public function __construct($source)
    {
        $this->target = $source;
        $this->singleton = true;
    }
}
