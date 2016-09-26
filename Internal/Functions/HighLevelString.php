<?php
//--------------------------------------------------------------------------------------------------
// High Level String
//--------------------------------------------------------------------------------------------------
//
// Author     : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
// Site       : www.znframework.com
// License    : The MIT License
// Copyright  : Copyright (c) 2012-2016, ZN Framework
//
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
// Objects
//--------------------------------------------------------------------------------------------------
//
// @param array $array
//
// @return object
//
//--------------------------------------------------------------------------------------------------
function objects(Array $array) : stdClass
{
    $object = new stdClass;

    return internalObjects($array, $object);
}

//--------------------------------------------------------------------------------------------------
// charsetList()
//--------------------------------------------------------------------------------------------------
//
// @param void
//
// @return array
//
//--------------------------------------------------------------------------------------------------
function charsetList() : Array
{
    return mb_list_encodings();
}

//--------------------------------------------------------------------------------------------------
// compare()
//--------------------------------------------------------------------------------------------------
//
// @param string $p1
// @param string $p2
// @param string $p3
//
// @return Bool
//
//--------------------------------------------------------------------------------------------------
function compare(String $p1, String $operator, String $p2) : Bool
{
    return version_compare($p1, $p2, $operator);
}

//--------------------------------------------------------------------------------------------------
// EOL
//--------------------------------------------------------------------------------------------------
//
// @param int $repeat = 1
//
// @return string
//
//--------------------------------------------------------------------------------------------------
function eol(Int $repeat = 1) : String
{
    return str_repeat(EOL, $repeat);
}

//--------------------------------------------------------------------------------------------------
// getOS()
//--------------------------------------------------------------------------------------------------
//
// @param void
//
// @return string
//
//--------------------------------------------------------------------------------------------------
function getOS() : String
{
    if( stristr(PHP_OS, 'WIN') )
    {
        return 'WIN';
    }
    elseif( stristr(PHP_OS, 'MAC') )
    {
        return 'MAC';
    }
    elseif( stristr(PHP_OS, 'LINUX') )
    {
        return 'LINUX';
    }
    else
    {
        return 'UNKNOWN';
    }
}

//--------------------------------------------------------------------------------------------------
// suffix()
//--------------------------------------------------------------------------------------------------
//
// @param string $string
// @param string $fix = '/'
//
// @return string
//
//--------------------------------------------------------------------------------------------------
function suffix(String $string, String $fix = '/') : String
{
    if( strlen($fix) <= strlen($string) )
    {
        $suffix = substr($string, -strlen($fix));

        if( $suffix !== $fix)
        {
            $string = $string.$fix;
        }
    }
    else
    {
        $string = $string.$fix;
    }

    if( $string === '/' )
    {
        return false;
    }

    return $string;
}

//--------------------------------------------------------------------------------------------------
// prefix()
//--------------------------------------------------------------------------------------------------
//
// @param string $string
// @param string $fix = '/'
//
// @return string
//
//--------------------------------------------------------------------------------------------------
function prefix(String $string, String $fix = '/') : String
{
    if( strlen($fix) <= strlen($string) )
    {
        $prefix = substr($string, 0, strlen($fix));

        if( $prefix !== $fix )
        {
            $string = $fix.$string;
        }
    }
    else
    {
        $string = $fix.$string;
    }

    if( $string === '/' )
    {
        return false;
    }

    return $string;
}

//--------------------------------------------------------------------------------------------------
// presuffix()
//--------------------------------------------------------------------------------------------------
//
// @param string $string
// @param string $fix = '/'
//
// @return string
//
//--------------------------------------------------------------------------------------------------
function presuffix(String $string, String $fix = '/') : String
{
    return suffix(prefix($string, $fix), $fix);
}

//--------------------------------------------------------------------------------------------------
// divide()
//--------------------------------------------------------------------------------------------------
//
// @param string $str
// @param string $separator = '|'
// @param scalar $index     = 0
//
// @return mixed
//
//--------------------------------------------------------------------------------------------------
function divide(String $str, String $separator = '|', String $index = '0')
{
    $arrayEx = explode($separator, $str);

    if( $index === 'all' )
    {
        return $arrayEx;
    }

    if( $index < 0 )
    {
        $ind = (count($arrayEx) + ($index));
    }
    elseif( $index === 'last' )
    {
        $ind = (count($arrayEx) - 1);
    }
    elseif( $index === 'first' )
    {
        $ind = 0;
    }
    else
    {
        $ind = $index;
    }

    return $arrayEx[$ind] ?? false;
}

//--------------------------------------------------------------------------------------------------
// lastError()
//--------------------------------------------------------------------------------------------------
//
// @param string $type = NULL
//
// @param mixed
//
//--------------------------------------------------------------------------------------------------
function lastError(String $type = NULL)
{
    $result = error_get_last();

    if( $type === NULL )
    {
        return $result;
    }
    else
    {
        return $result[$type] ?? false;
    }
}
