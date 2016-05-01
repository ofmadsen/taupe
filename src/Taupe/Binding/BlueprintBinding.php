<?php
namespace Taupe\Binding;

use Taupe\Binding\Binding;

/**
 * Blueprint binding container.
 *
 * @author Oliver Finn Madsen <mail@ofmadsen.com>
 */
class BlueprintBinding extends Binding
{
    /**
     * Constructor.
     *
     * Defines the target to be the source as the blueprint will be used for instantiation.
     *
     * @param string $source
     * @param string $blueprint
     * @param bool $singleton
     */
    public function __construct($source, $blueprint, $singleton)
    {
        $this->target = $source;
        $this->blueprint = $blueprint;
        $this->singleton = $singleton;
    }
}
