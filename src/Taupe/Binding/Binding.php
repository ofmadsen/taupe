<?php
namespace Taupe\Binding;

/**
 * Abstract binding container.
 *
 * @author Oliver Finn Madsen <mail@ofmadsen.com>
 */
abstract class Binding
{
    /** @var string */
    public $target = '';

    /** @var bool */
    public $singleton = false;

    /** @var mixed */
    public $instance;

    /** @var string */
    public $blueprint = '';
}
