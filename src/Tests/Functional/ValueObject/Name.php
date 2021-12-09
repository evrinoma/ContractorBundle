<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\ValueObject;

use Evrinoma\TestUtilsBundle\ValueObject\ValueObjectTest;

class Name implements ValueObjectTest
{
//region SECTION: Fields
    protected const VALUE = "Test company";
//endregion Fields

//region SECTION: Public
    public static function value(): string
    {
        return static::VALUE;
    }

    public static function wrong(): string
    {
        return strrev(static::value());
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