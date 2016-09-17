<?php namespace ZN\Helpers\Searcher;

interface DataInterface
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
    // Do
    //--------------------------------------------------------------------------------------------------------
    //
    // @param mixed  $searchData
    // @param mixed  $searchWord
    // @param string $output: boolean, position, string
    //
    //--------------------------------------------------------------------------------------------------------
    public function do($searchData, $searchWord, String $output = 'boolean');
}
