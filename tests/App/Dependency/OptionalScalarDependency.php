<?php
namespace Test\App\Dependency;

use stdClass;

class OptionalScalarDependency
{
    public $class;
    public $array;
    public $value;

    public function __construct(stdClass $class = null, array $array = [], $value = 200)
    {
        $this->class = $class;
        $this->array = $array;
        $this->value = $value;
    }
}
