<?php
namespace Test;

use Taupe\Container;
use Taupe\Instantiator;

trait SetUpTrait
{
    private $container;
    private $instantiator;

    public function setUp()
    {
        $this->container = new Container();
        $this->instantiator = new Instantiator($this->container);
    }
}
