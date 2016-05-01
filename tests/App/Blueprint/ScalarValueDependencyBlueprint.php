<?php
namespace Test\App\Blueprint;

use Taupe\BlueprintInterface;
use Test\App\Dependency\ScalarValueDependency;

class ScalarValueDependencyBlueprint implements BlueprintInterface
{
    public function build()
    {
        return new ScalarValueDependency(200);
    }
}
