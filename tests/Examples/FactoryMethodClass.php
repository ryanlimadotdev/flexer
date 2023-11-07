<?php


class FactoryMethodClass
{
    public static function create(): FactoryMethodClass
    {
        return new FactoryMethodClass();
    }
}