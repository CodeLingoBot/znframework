<?php namespace ZN\CryptoGraphy\Encode;

use IS;

class GoldenAlgorithm extends EncodeExtends
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
    // Golden
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $data
    // @param string $additional
    //
    //--------------------------------------------------------------------------------------------------------
    public static function create(String $data, String $additional = 'default') : String
    {
        $algo = CRYPTOGRAPHY_ENCODE_CONFIG['type'];

        if( ! IS::hash($algo) )
        {
            $algo = 'md5';
        }

        $additional = hash($algo, $additional);

        $data = hash($algo, $data);

        return hash($algo, $data . $additional);
    }
}
