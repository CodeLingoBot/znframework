<?php
//--------------------------------------------------------------------------------------------------
// String
//--------------------------------------------------------------------------------------------------
//
// Author     : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
// Site       : www.znframework.com
// License    : The MIT License
// Copyright  : Copyright (c) 2012-2016, ZN Framework
//
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
// Length
//--------------------------------------------------------------------------------------------------
//
// @param string data
//
// @return int
//
//--------------------------------------------------------------------------------------------------
function length($data) : Int
{
    if( is_scalar($data) )
    {
        return strlen($data);
    }
    else
    {
        return count((array) $data);
    }
}

//--------------------------------------------------------------------------------------------------
// Illustrate
//--------------------------------------------------------------------------------------------------
//
// @param string $const
// @param  mixed $value
// @return mixed
//
//--------------------------------------------------------------------------------------------------
function illustrate(String $const, $value = NULL)
{
    if( ! defined($const) )
    {
        define($const, $value);
    }
    else
    {
        return $value;
    }

    return constant($const);
}

//--------------------------------------------------------------------------------------------------
// Symbol
//--------------------------------------------------------------------------------------------------
//
// @param string $symbolName
//
// @return string
//
//--------------------------------------------------------------------------------------------------
function symbol(String $symbolName = 'turkishLira') : String
{
    $symbol = Config::get('Symbols', $symbolName);

    if( ! empty($symbol) )
    {
        return $symbol;
    }
    else
    {
        return false;
    }
}

//--------------------------------------------------------------------------------------------------
// getErrorMessage()
//--------------------------------------------------------------------------------------------------
//
// @param string $langFile
// @param string $errorMsg
// @param mixed  $ex
//
// @return string
//
//--------------------------------------------------------------------------------------------------
function getErrorMessage(String $langFile, String $errorMsg = '', $ex = NULL) : String
{
    $style  = 'border:solid 1px #E1E4E5;';
    $style .= 'background:#FEFEFE;';
    $style .= 'padding:10px;';
    $style .= 'margin-bottom:10px;';
    $style .= 'font-family:Calibri, Ebrima, Century Gothic, Consolas, Courier New, Courier, monospace, Tahoma, Arial;';
    $style .= 'color:#666;';
    $style .= 'text-align:left;';
    $style .= 'font-size:14px;';

    $exStyle = 'color:#900;';

    if( ! is_array($ex) )
    {
        $ex = '<span style="'.$exStyle .'">'.$ex.'</span>';
    }
    else
    {
        $newArray = [];

        if( ! empty($ex) ) foreach( $ex as $k => $v )
        {
            $newArray[$k] = $v;
        }

        $ex = $newArray;
    }

    $str  = "<div style=\"$style\">";

    if( ! empty($errorMsg) )
    {
        $str .= lang($langFile, $errorMsg, $ex);
    }
    else
    {
        $str .= $langFile;
    }

    $str .= '</div><br>';

    return $str;
}

//--------------------------------------------------------------------------------------------------
// report()
//--------------------------------------------------------------------------------------------------
//
// @param string $subject
// @param string $message
// @param string $destination
// @param string $time
//
// @return bool
//
//--------------------------------------------------------------------------------------------------
function report(String $subject, String $message, String $destination = '', String $time = '') : Bool
{
    if( ! Config::get('General', 'log')['createFile'] )
    {
        return false;
    }

    if( empty($destination) )
    {
        $destination = str_replace(' ', '-', $subject);
    }

    $logDir    = STORAGE_DIR.'Logs/';
    $extension = '.log';

    if( ! is_dir($logDir) )
    {
        Folder::create($logDir, 0755);
    }

    if( is_file($logDir.suffix($destination, $extension)) )
    {
        if( empty($time) )
        {
            $time = Config::get('General', 'log')['fileTime'];
        }

        $createDate = File::createDate($logDir.suffix($destination, $extension), 'd.m.Y');
        $endDate    = strtotime("$time", strtotime($createDate));
        $endDate    = date('Y.m.d', $endDate);

        if( date('Y.m.d')  >  $endDate )
        {
            File::delete($logDir.suffix($destination, $extension));
        }
    }

    $message = "IP: ".ipv4()." | Subject: ".$subject.' | Date: '.Date::set('{dayNumber0}.{monthNumber0}.{year} {H024}:{minute}:{second}')." | Message: ".$message.EOL;
    return error_log($message, 3, $logDir.suffix($destination, $extension));
}

//--------------------------------------------------------------------------------------------------
// headers()
//--------------------------------------------------------------------------------------------------
//
// @param mixed $header
//
//--------------------------------------------------------------------------------------------------
function headers($header)
{
    if( empty($header) )
    {
        return false;
    }

    if( ! is_array($header) )
    {
         header($header);
    }
    else
    {
        if( isset($header) ) foreach( $header as $k => $v )
        {
            header($v);
        }
    }
}

//--------------------------------------------------------------------------------------------------
// currentUri()
//--------------------------------------------------------------------------------------------------
//
// @param void
//
// @return string
//
//--------------------------------------------------------------------------------------------------
function currentUri() : String
{
    $requestUri = server('requestUri');

    if( BASE_DIR !== '/' )
    {
        $cu = str_replace(BASE_DIR, '', $requestUri);
    }
    else
    {
        $cu = substr($requestUri, 1);
    }

    if( indexStatus() )
    {
        $cu = str_replace(indexStatus(), '', $cu);
    }

    return $cu;
}
