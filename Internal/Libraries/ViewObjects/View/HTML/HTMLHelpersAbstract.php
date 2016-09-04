<?php namespace ZN\ViewObjects\View\Abstracts;

use CallController;

abstract class HTMLHelpersAbstract
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
    // Create
    //--------------------------------------------------------------------------------------------------------
    //
    // @param variadic $elements
    //
    //--------------------------------------------------------------------------------------------------------
    abstract public function create(...$elements) : String;
}
