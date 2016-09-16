<?php namespace ZN\IndividualStructures;

class InternalBenchmark extends \FactoryController
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Telif Hakkı: Copyright (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    const factory =
    [
        'methods' =>
        [
            'start'            => 'Benchmark\Testing::start',
            'end'              => 'Benchmark\Testing::end',
            'elapsedtime'      => 'Benchmark\ElapsedTime::calculate',
            'usedfiles'        => 'Benchmark\FileUsage::list',
            'usedfilecount'    => 'Benchmark\FileUsage::count',
            'calculatedmemory' => 'Benchmark\MemoryUsage::calculate',
            'memoryusage'      => 'Benchmark\MemoryUsage::normal',
            'maxmemoryusage'   => 'Benchmark\MemoryUsage::maximum'
        ]
    ];
}
