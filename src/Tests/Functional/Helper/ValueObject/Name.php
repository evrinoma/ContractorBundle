<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Helper\ValueObject;

class Name implements ValueObjectTest
{
    protected const VALUE = "Test company";

    public static function value():string
    {
        return static::VALUE;
    }

    public static function wrong():string
    {
        return strrev(static::value());
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