<?php namespace ZN\Helpers;

class InternalRounder extends \FactoryController implements InternalRounderInterface
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Telif Hakkı: Copyright (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    const factory =
    [
        'methods' =>
        [
            'up'      => 'Rounder\Up::do',
            'down'    => 'Rounder\Down::do',
            'average' => 'Rounder\Average::do'
        ]
    ];
}
