<?php namespace ZN\Controllers;
/**
 * ZN PHP Web Framework
 * 
 * "Simplicity is the ultimate sophistication." ~ Da Vinci
 * 
 * @package ZN
 * @license MIT [http://opensource.org/licenses/MIT]
 * @author  Ozan UYKUN [ozan@znframework.com]
 */


use ZN;
use ZN\Config;
use ZN\Autoloader;
use ZN\Restoration;
use stdClass;


class Controller
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
    // Public View
    //--------------------------------------------------------------------------------------------------------
    //
    // @param stdClass
    //
    //--------------------------------------------------------------------------------------------------------
    public $view;

    //--------------------------------------------------------------------------------------------------------
    // Public Masterpage
    //--------------------------------------------------------------------------------------------------------
    //
    // @param stdClass
    //
    //--------------------------------------------------------------------------------------------------------
    public $masterpage;

    //--------------------------------------------------------------------------------------------------------
    // Construct
    //--------------------------------------------------------------------------------------------------------
    //
    // @param void
    //
    //--------------------------------------------------------------------------------------------------------
    public function __construct()
    {
        if( defined('static::restore') )
        {
            Restoration::mode(static::restore);
        }

        $this->view       = new stdClass;
        $this->masterpage = new stdClass;

        ZN::$use =& $this;

        if( defined('static::extract') || Config::starting('extractViewData') === true ) foreach( View::$data as $key => $val )
        {
            ZN::$use->$key = $val;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // Autoloader Restart
    //--------------------------------------------------------------------------------------------------------
    //
    // @param void
    //
    //--------------------------------------------------------------------------------------------------------
    public function restart()
    {
        return Autoloader::restart();
    }

    //--------------------------------------------------------------------------------------------------------
    // Get
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $class
    //
    //--------------------------------------------------------------------------------------------------------
    public function __get($class)
    {
        if( ! isset($this->$class) )
        {
            return $this->$class = uselib($class);
        }
    }
}
