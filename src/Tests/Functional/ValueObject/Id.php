<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\ValueObject;

use Evrinoma\TestUtilsBundle\ValueObject\ValueObjectTest;

class Id implements ValueObjectTest
{
//region SECTION: Fields
    protected const VALUE = "1";
//endregion Fields

//region SECTION: Public
    public static function value(): string
    {
        return static::VALUE;
    }

    public static function wrong(): string
    {
        return "100000";
    }

    public static function empty(): string
    {
        return '';
    }

    public static function nullable()
    {
        return null;
    }
//endregion Public
}