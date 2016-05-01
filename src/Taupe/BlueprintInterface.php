<?php
namespace Taupe;

use Taupe\Instantiator;

/**
 * Blueprint interface.
 *
 * @author Oliver Finn Madsen <mail@ofmadsen.com>
 */
interface BlueprintInterface
{
    /**
     * Build method for building the blueprint.
     *
     * @return mixed
     */
    public function build();
}
