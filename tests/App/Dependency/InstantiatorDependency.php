<?php
namespace Test\App\Dependency;

use Taupe\Instantiator;

class InstantiatorDependency
{
    public $instantiator;

    public function __construct(Instantiator $instantiator)
    {
        $this->instantiator = $instantiator;
    }
}
