<?php namespace ZN\IndividualStructures\Cart;

use CLController, DriverAbility;

class CartCommon extends CLController
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Telif Hakkı: Copyright (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    use DriverAbility;

    //--------------------------------------------------------------------------------------------------------
    // Consts
    //--------------------------------------------------------------------------------------------------------
    //
    // @const string
    //
    //--------------------------------------------------------------------------------------------------------
    const config = 'IndividualStructures:cart';
    const driver =
    [
        'options' => ['session', 'cookie']
    ];
}
