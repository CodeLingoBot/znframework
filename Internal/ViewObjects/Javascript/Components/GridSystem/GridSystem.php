<?php namespace ZN\ViewObjects\Javascript\Components;

use Html, Form;
use ZN\IndividualStructures\Buffer\Callback as BufferCallback;

class GridSystem extends ComponentsExtends
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
    // Row
    //--------------------------------------------------------------------------------------------------------
    //
    // @param callable $columns
    // @param array    $attr = NULL
    //
    //--------------------------------------------------------------------------------------------------------
    public function row(Callable $columns, Array $attr = [])
    {
        $content = BufferCallback::do($columns, [$this]);

        echo Html::attr($attr)->class('row')->div($content);
    }

    //--------------------------------------------------------------------------------------------------------
    // Col
    //--------------------------------------------------------------------------------------------------------
    //
    // @poram scalar   $size
    // @param callable $code
    // @param array    $attr = NULL
    //
    //--------------------------------------------------------------------------------------------------------
    public function col($size, Callable $code, Array $attr = [])
    {
        $content = BufferCallback::do($code, [new Form, new Html]);

        echo Html::attr($attr)->class('col-' . ( is_numeric($size) ? 'lg-' . $size : $size))->div($content);
    }

    //--------------------------------------------------------------------------------------------------------
    // Generate
    //--------------------------------------------------------------------------------------------------------
    //
    // @param callable $grid
    //
    //--------------------------------------------------------------------------------------------------------
    public function generate(Callable $grid) : String
    {
        return $this->prop
        ([
            'contents' => BufferCallback::do($grid, [$this])
        ]);
    }
}
