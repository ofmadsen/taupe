<?php
namespace Test\App\Unresolvable;

use stdClass;

class StdClassDependency
{
    public $value;

    public function __construct(stdClass $value)
    {
        $this->value = $value;
    }
}
