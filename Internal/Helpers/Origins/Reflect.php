<?php namespace ZN\Helpers;

use ZN\DataTypes\Arrays;
use ZN\DataTypes\Json;
use ZN\IndividualStructures\Buffer;

class Reflect
{
    //--------------------------------------------------------------------------------------------------------
    // Reflect -> 5.4.5
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Copyright  : (c) 2012-2016, znframework.com
    //
    //-------------------------------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------------------------------
    // Classes
    //--------------------------------------------------------------------------------------------------------
    //
    // @var array
    //
    //---------------------------------------------------------------------------------------------------------
    protected $classes = 
    [
        'class', 
        'extension', 
        'function',  
        'method', 
        'object', 
        'parameter', 
        'property'
    ];

    //--------------------------------------------------------------------------------------------------------
    // Magic Call
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $method
    // @param array  $parameters
    //
    //---------------------------------------------------------------------------------------------------------
    public function __call($method, $parameters)
    {
        $lower = strtolower($method);

        if( in_array($lower, $this->classes) )
        {
            return $this->call($parameters, $method);
        }

        return $this->call($parameters)->$method();
    }
    
    //--------------------------------------------------------------------------------------------------------
    // Annotation -> 5.4.8
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $class
    // @param string $function
    //
    //--------------------------------------------------------------------------------------------------------
    public function annotation(String $class, String $function = NULL) : \stdClass
    {
        if( strstr($class, '::') )
        {
            $method = explode('::', $class);

            $class    = $method[0];
            $function = $method[1];
        }

        if( $function[0] === '$' )
        {
            $class = $this->property($class, ltrim($function, '$'));
        }
        else
        {
            $class = $this->class($class);

            if( $function !== NULL )
            {
                $class = $class->getMethod($function);
            }
        } 
        
        preg_match_all('/@(\w+.*?)\s+(.*?)\s+\*/s', $class->getDocComment(), $match);

        $keys   = $match[1] ?? [];
        $values = $match[2] ?? [];
    
        $values = array_map(function($data)
        {
            if( Json\ErrorInfo::check($data) )
            {
                return Json\Decode::object($data);
            }
            elseif( $data[0] === ':' )
            {
                return eval('?><?php return ' . ltrim(suffix($data, ';'), ':'));
            }

            return $data;

        }, $values);

        return (object) array_combine($keys, $values);
    }

    //--------------------------------------------------------------------------------------------------------
    // Protected Call
    //--------------------------------------------------------------------------------------------------------
    //
    // @param array  $parameters
    // @PARAM string $type 
    //
    //--------------------------------------------------------------------------------------------------------
    protected function call($parameters, $type = NULL)
    {
        $class = 'Reflection' . $type;

        if( $type === 'class' )
        {
            $parameters[0] = \Classes::class($parameters[0]);            
        }

        return (new $class(...$parameters));
    }
}
