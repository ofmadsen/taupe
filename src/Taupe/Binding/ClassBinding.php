<?php
namespace Taupe\Binding;

use Taupe\Binding\Binding;

/**
 * Class binding container.
 *
 * @author Oliver Finn Madsen <mail@ofmadsen.com>
 */
class ClassBinding extends Binding
{
    /**
     * Constructor.
     *
     * @param string $target
     * @param bool $singleton
     */
    public function __construct($target, $singleton)
    {
        $this->target = $target;
        $this->singleton = $singleton;
    }
}
