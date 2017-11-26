<?php namespace ZN\ViewObjects\Javascript\Components;

use Html;
use ZN\IndividualStructures\Buffer\Callback as BufferCallback;

class Tabs extends ComponentsExtends
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Copyright  : (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    protected $tabs = [];

    //--------------------------------------------------------------------------------------------------------
    // Tab
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string   $menu
    // @param callable $content
    //
    //--------------------------------------------------------------------------------------------------------
    public function tab(String $menu, Callable $content)
    {
        $content = BufferCallback::do($content, [new Html]);

        $this->tabs[$menu] = $content;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // Pill
    //--------------------------------------------------------------------------------------------------------
    //
    // @param callable $tab
    //
    //--------------------------------------------------------------------------------------------------------
    public function pill(Callable $tab) : String
    {
        return $this->generate($tab, 'pill');
    }

    //--------------------------------------------------------------------------------------------------------
    // Generate
    //--------------------------------------------------------------------------------------------------------
    //
    // @param callable $tab
    //
    //--------------------------------------------------------------------------------------------------------
    public function generate(Callable $tab, $type = 'tab') : String
    {
        $tab($this);

        return $this->prop
        ([
            'tabs' => $this->tabs,
            'type' => $type
        ]);
    }
}
