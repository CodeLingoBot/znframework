<?php namespace ZN\IndividualStructures\Import;

interface TemplateInterface
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
    // template()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $page
    // @param array  $data
    // @param bool   $obGetContents
    //
    //--------------------------------------------------------------------------------------------------------
    public function use(String $page, Array $data = NULL, Bool $obGetContents = false);
}
