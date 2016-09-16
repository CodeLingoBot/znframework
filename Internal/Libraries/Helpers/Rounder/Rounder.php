<?php namespace ZN\Helpers;

use CallController;

class InternalRounder extends CallController implements RounderInterface
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Telif Hakkı: Copyright (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------------------------------
    // Up
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $number
    // @param int    $count
    //
    //--------------------------------------------------------------------------------------------------------
    public function up(Float $number, Int $count = 0) : Float
    {
        return RounderFactory::class('RounderUp')->do($number, $count);
    }

    //--------------------------------------------------------------------------------------------------------
    // Down
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $number
    // @param int    $count
    //
    //--------------------------------------------------------------------------------------------------------
    public function down(Float $number, Int $count = 0) : Float
    {
        return RounderFactory::class('RounderDown')->do($number, $count);
    }

    //--------------------------------------------------------------------------------------------------------
    // Average
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $number
    // @param int    $count
    //
    //--------------------------------------------------------------------------------------------------------
    public function average(Float $number, Int $count = 0) : Float
    {
        return RounderFactory::class('RounderAverage')->do($number, $count);
    }
}
