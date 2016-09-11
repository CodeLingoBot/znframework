<?php namespace ZN\Services\Remote;

use File;

class InternalProcessor implements ProcessorInterface
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
    // Php
    //--------------------------------------------------------------------------------------------------------
    //
    // @var string
    //
    //--------------------------------------------------------------------------------------------------------
    protected $path = 'C:\xampp7\php\php.exe';

    //--------------------------------------------------------------------------------------------------------
    // Output
    //--------------------------------------------------------------------------------------------------------
    //
    // @var array
    //
    //--------------------------------------------------------------------------------------------------------
    protected $output;

    //--------------------------------------------------------------------------------------------------------
    // Return
    //--------------------------------------------------------------------------------------------------------
    //
    // @var int
    //
    //--------------------------------------------------------------------------------------------------------
    protected $return;

    //--------------------------------------------------------------------------------------------------------
    // Command
    //--------------------------------------------------------------------------------------------------------
    //
    // @var string
    //
    //--------------------------------------------------------------------------------------------------------
    protected $command;

    //--------------------------------------------------------------------------------------------------------
    // String Command
    //--------------------------------------------------------------------------------------------------------
    //
    // @var string
    //
    //--------------------------------------------------------------------------------------------------------
    protected $stringCommand;

    //--------------------------------------------------------------------------------------------------------
    // Command
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $command
    //
    //--------------------------------------------------------------------------------------------------------
    public function command(String $command) : String
    {
        $phpCommand = "require_once '".REAL_BASE_DIR."processor'; ".$command.";";
        $phpCommand = presuffix(str_replace('"', '\"', $phpCommand), '"');

        $commands  = $this->path;
        $commands .= ' -r ';
        $commands .= $phpCommand;

        $this->stringCommand = $commands;

        return $this->_run($commands);
    }

    //--------------------------------------------------------------------------------------------------------
    // File
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $file
    //
    //--------------------------------------------------------------------------------------------------------
    public function file(String $file) : String
    {
        $content = File::read($file);
        $content = str_ireplace('<?php', NULL, $content);

        return $this->command($content);
    }

    //--------------------------------------------------------------------------------------------------------
    // Controller
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $path
    //
    //--------------------------------------------------------------------------------------------------------
    public function controller(String $path) : String
    {
        $command  = '$datas = ZN\Core\Structure::data("'.$path.'");';
        $command .= '$parameters = $datas["parameters"];';
        $command .= '$page       = $datas["page"];';
        $command .= '$isFile     = $datas["file"];';
        $command .= '$function   = $datas["function"];';
        $command .= '$namespace  = $datas["namespace"];';
        $command .= 'if( ! is_file($isFile) )';
        $command .= '{';
        $command .= 'exit("Error: URL does not contain a valid controller information! `".$page."` controller could not be found!");';
        $command .= '}';
        $command .= 'require_once $isFile;';
        $command .= 'if( ! class_exists($page, false) )';
        $command .= '{';
        $command .= '$page = $namespace.$page;';
        $command .= '}';
        $command .= 'if( strtolower($function) === "index" && ! is_callable([$page, $function]) )';
        $command .= '{';
        $command .= '$function = "main";';
        $command .= '}';
        $command .= 'if( is_callable([$page, $function]) )';
        $command .= '{';
        $command .= 'uselib($page)->$function(...$parameters);';
        $command .= '}';
        $command .= 'else';
        $command .= '{';
        $command .= 'exit("Error: URL does not contain a valid function or method information! `".$function."` method could not be found!");';
        $command .= '}';

        return $this->command($command);
    }

    //--------------------------------------------------------------------------------------------------------
    // PHP Path
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $php
    //
    //--------------------------------------------------------------------------------------------------------
    public function path(String $path) : InternalProcessor
    {
        $this->path = $path;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // Output
    //--------------------------------------------------------------------------------------------------------
    //
    // @param void
    //
    //--------------------------------------------------------------------------------------------------------
    public function output() : Array
    {
        return $this->output;
    }

    //--------------------------------------------------------------------------------------------------------
    // Return
    //--------------------------------------------------------------------------------------------------------
    //
    // @param void
    //
    //--------------------------------------------------------------------------------------------------------
    public function return() : Int
    {
        return $this->return;
    }

    //--------------------------------------------------------------------------------------------------------
    // String Command
    //--------------------------------------------------------------------------------------------------------
    //
    // @param void
    //
    //--------------------------------------------------------------------------------------------------------
    public function stringCommand() : String
    {
        return $this->stringCommand;
    }

    //--------------------------------------------------------------------------------------------------------
    // Run
    //--------------------------------------------------------------------------------------------------------
    //
    // @param void
    //
    //--------------------------------------------------------------------------------------------------------
    protected function _run($command)
    {
        $return = exec($command, $this->output, $this->return);

        $this->_defaultVariables();

        return $return;
    }

    //--------------------------------------------------------------------------------------------------------
    // Protected Default Variables
    //--------------------------------------------------------------------------------------------------------
    //
    // @param void
    //
    //--------------------------------------------------------------------------------------------------------
    protected function _defaultVariables()
    {
        $this->command = NULL;
        $this->path    = NULL;
    }
}
