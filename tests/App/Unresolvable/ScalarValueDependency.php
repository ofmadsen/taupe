<?php
namespace Test\App\Unresolvable;

class ScalarValueDependency
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
