<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Helper\ValueObject;

class Id implements ValueObjectTest
{
    protected const VALUE = "1";

    public static function value():string
    {
        return static::VALUE;
    }

    public static function wrong():string
    {
        return "100000";
    }

    public static function empty():string
    {
        return '';
    }

    public static function nullable()
    {
        return null;
    }
}