<?php namespace ZN\CryptoGraphy;

class CryptoUnitTest extends \UnitTestController
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Telif Hakkı: Copyright (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    const unit =
    [
        'class'   => 'Crypto',
        'methods' =>
        [
            'encrypt' => ['string', []],
            'decrypt' => ['string', []],
            'keygen'  => [10]
        ]
    ];
}
