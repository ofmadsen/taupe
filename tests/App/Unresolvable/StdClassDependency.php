<?php
namespace Test\App\Unresolvable;

use stdClass;

class StdClassDependency
{
    public function __construct(stdClass $value)
    {
    }
}
