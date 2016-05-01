<?php
namespace Test\App\Dependency;

class ScalarValueDependency
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
