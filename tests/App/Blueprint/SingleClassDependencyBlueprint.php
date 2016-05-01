<?php
namespace Test\App\Blueprint;

use Taupe\BlueprintInterface;
use Test\App\Dependency\SingleClassDependency;
use Test\App\EmptyConstructor;

class SingleClassDependencyBlueprint implements BlueprintInterface
{
    private $empty;

    public function __construct(EmptyConstructor $empty)
    {
        $this->empty = $empty;
    }

    public function build()
    {
        return new SingleClassDependency($this->empty);
    }
}
