<?php namespace ZN\Filesystem\Exception;
/**
 * ZN PHP Web Framework
 * 
 * "Simplicity is the ultimate sophistication." ~ Da Vinci
 * 
 * @package ZN
 * @license MIT [http://opensource.org/licenses/MIT]
 * @author  Ozan UYKUN [ozan@znframework.com]
 */

use GeneralException;
use ZN\Language\Lang;

class FileRemoteUploadException extends GeneralException
{
    public function __construct($file)
    {
        parent::__construct(Lang::select('Exception', 'fileRemoteUpload', $file));
    }
}
