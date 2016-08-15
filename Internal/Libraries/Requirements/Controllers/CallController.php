<?php namespace ZN\Requirements;

class CallController extends BaseController
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
    // Call
    //--------------------------------------------------------------------------------------------------------
    // 
    // Magic Call
    //
    //--------------------------------------------------------------------------------------------------------
    public function __call($method = '', $param = '')
    {   
        die(getErrorMessage
        (
            'Error', 
            'undefinedFunction', 
            divide(str_ireplace(STATIC_ACCESS, '', get_called_class()), '\\', -1)."::$method()"
        ));
    }
}

class_alias('ZN\Requirements\CallController', 'CallController');