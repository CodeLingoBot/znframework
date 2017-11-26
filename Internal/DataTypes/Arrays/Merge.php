<?php namespace ZN\DataTypes\Arrays;

class Merge
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Copyright  : (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------------------------------
    // Recursive Merge
    //--------------------------------------------------------------------------------------------------------
    //
    // @param ...args
    //
    //--------------------------------------------------------------------------------------------------------
    public static function recursive(...$args) : Array
    {
        return array_merge_recursive(...$args);
    }

    //--------------------------------------------------------------------------------------------------------
    // Merge
    //--------------------------------------------------------------------------------------------------------
    //
    // @param ...args
    //
    //--------------------------------------------------------------------------------------------------------
    public static function do(...$args) : Array
    {
        return array_merge(...$args);
    }
}
