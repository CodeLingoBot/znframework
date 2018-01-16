<?php namespace ZN\Filesystem;
/**
 * ZN PHP Web Framework
 * 
 * "Simplicity is the ultimate sophistication." ~ Da Vinci
 * 
 * @package ZN
 * @license MIT [http://opensource.org/licenses/MIT]
 * @author  Ozan UYKUN [ozan@znframework.com]
 */

use ZipArchive;
use ZN\Base;
use ZN\Filesystem;
use ZN\Filesystem\Exception\FileNotFoundException;
use ZN\Filesystem\Exception\FolderNotFoundException;

class Forge
{
    /**
     * Creates a file.
     * 
     * @param string $name
     * 
     * @return bool
     */
    public static function create(String $name) : Bool
    {
        $name = Info::rpath($name);

        if( ! is_file($name) )
        {
            return touch($name);
        }

        return false;
    }

    /**
     * Performs data modification on the file.
     * 
     * @param string $file
     * @param mixed  $data
     * @param mixed  $replace
     * 
     * @return string
     */
    public static function replace(String $file, $data, $replace) : String
    {
        $file = Info::rpath($file);

        if( ! is_file($file))
        {
            return false;
        }

        return Filesystem::replaceData($file, $data, $replace);
    }

    /**
     * Deletes the file.
     * 
     * @param string $name
     * 
     * @return bool
     */
    public static function delete(String $name) : Bool
    {
        $name = Info::rpath($name);

        if( ! is_file($name))
        {
            throw new FileNotFoundException($name);
        }
        else
        {
            return unlink($name);
        }
    }

    /**
     * Extracts a zip file to the specified location.
     * 
     * @param string $source
     * @param string $target
     * 
     * @return bool
     */
    public static function zipExtract(String $source, String $target = NULL) : Bool
    {
        $source = Info::rpath($source);
        $target = Info::rpath($target);

        $source = Base::suffix($source, '.zip');

        if( ! file_exists($source) )
        {
            throw new FileNotFoundException($source);
        }

        if( empty($target) )
        {
            $target = Extension::remove($source);
        }

        $zip = new ZipArchive;

        if( $zip->open($source) === true )
        {
            $zip->extractTo($target);
            $zip->close();

            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Create a zip file.
     * 
     * @param string $path
     * @param array  $data
     * 
     * @return bool
     */
    public static function createZip(String $path, Array $data) : Bool
    {
        $path    = Info::rpath($path);
        $zip     = new ZipArchive;
        $zipPath = Base::suffix($path, ".zip");

        if( file_exists($zipPath) )
        {
            unlink($zipPath);
        }

        if( ! is_dir($pathDirName = Info::pathInfo($path, 'dirname')) )
        {
            mkdir($pathDirName);
        }

        if( $zip->open($zipPath, ZipArchive::CREATE) !== true )
        {
            return false;
        }

        $status = '';

        if( ! empty($data) ) foreach( $data as $key => $val )
        {
            if( is_numeric($key) )
            {
                $file = $val;
                $fileName = NULL;
            }
            else
            {
                $file = $key;
                $fileName = $val;
            }

            if( is_dir($file) )
            {
                $allFiles = FileList::allFiles($file, true);

                foreach( $allFiles as $f )
                {
                    $status = $zip->addFile($f, $f);
                }
            }
            else
            {
                $status = $zip->addFile($file, $fileName);
            }
        }

        return $zip->close();
    }

    /**
     * Change the name of a file.
     * 
     * @param string $oldName
     * @param string $newName
     * 
     * @return bool
     */
    public static function rename(String $oldName, String $newName) : Bool
    {
        $oldName = Info::rpath($oldName);

        if( ! file_exists($oldName) )
        {
            throw new FileNotFoundException($oldName);
        }

        return rename($oldName, $newName);
    }

    /**
     * Clears file status cache
     * 
     * @param string $fileName = NULL
     * @param bool   $real     = false
     */
    public static function cleanCache(String $fileName = NULL, Bool $real = false)
    {
        $fileName = Info::rpath($fileName);

        if( ! file_exists($fileName) )
        {
            clearstatcache($real);
        }
        else
        {
            clearstatcache($real, $fileName);
        }
    }

    /**
     * Truncates a file to a given length
     * 
     * @param string $file
     * @param int    $limit = 0
     * @param string $mode  = 'r+'
     */
    public static function truncate(String $file, Int $limit = 0, String $mode = 'r+')
    {
        $file = Info::rpath($file);

        if( ! is_file($file) )
        {
            throw new FileNotFoundException($file);
        }

        $fileOpen  = fopen($file, $mode);
        $fileWrite = ftruncate($fileOpen, $limit);

        fclose($fileOpen);
    }

    /**
     * Changes file mode.
     * 
     * @param string $name
     * @param int    $permission = 0755
     * 
     * @return bool
     */
    public static function permission(String $name, Int $permission = 0755) : Bool
    {
        $name = Info::rpath($name);

        if( ! file_exists($name) )
        {
            throw new FileNotFoundException($name);
        }

        return chmod($name, $permission);
    }

    /**
     * Create an index.
     * 
     * @param string $file
     * @param int    $permission = 0755
     * @param bool   $recursive  = true
     * 
     * @return bool
     */
    public static function createFolder(String $file, Int $permission = 0755, Bool $recursive = true) : Bool
    {
        return Filesystem::createFolder(Info::rpath($file), $permission, $recursive);
    }

    /**
     * Used to delete an empty directory.
     * 
     * @param string $folder
     * 
     * @return bool
     */
    public static function deleteEmptyFolder(String $folder) : Bool
    {
        $folder = Info::rpath($folder);

        if( ! is_dir($folder) )
        {
           return false;
        }

        return rmdir($folder);
    }

    /**
     * Used to delete a directory along with its contents.
     * 
     * @param string $name
     * 
     * @return bool
     */
    public static function deleteFolder(String $name) : Bool
    {
        $name = Info::rpath($name);

        if( is_file($name) )
        {
            return unlink($name);
        }
        else
        {
            if( ! FileList::files($name) )
            {
                return self::deleteEmptyFolder($name);
            }
            else
            {
                for( $i = 0; $i < count(FileList::files($name)); $i++ )
                {
                    foreach( FileList::files($name) as $val )
                    {
                        self::deleteFolder($name."/".$val);
                    }
                }
            }

            return self::deleteEmptyFolder($name);
        }
    }

    /**
     * Used to copy a directory to another specified location. 
     * This includes other subdirectories and files of the directory to be copied.
     * 
     * @param string $source
     * @param string $target
     * 
     * @return bool
     */
    public static function copy(String $source, String $target) : Bool
    {
        $source = Info::rpath($source);
        $target = Info::rpath($target);

        if( ! file_exists($source) )
        {
            throw new FolderNotFoundException($source);
        }

        if( is_dir($source) )
        {
            if( ! FileList::files($source) )
            {
                $emptyFilePath = Base::suffix($source, DS) . 'empty';

                self::create($emptyFilePath);

                return copy($emptyFilePath, $target);
            }
            else
            {
                if( ! is_dir($target) && ! file_exists($target) )
                {
                    self::createFolder($target);
                }

                if( is_array(FileList::files($source)) ) foreach( FileList::files($source) as $val )
                {
                    $sourceDir = $source."/".$val;
                    $targetDir = $target."/".$val;

                    if( is_file($sourceDir) )
                    {
                        copy($sourceDir, $targetDir);
                    }

                    self::copy($sourceDir, $targetDir);
                }

                return true;
            }
        }
        else
        {
            return copy($source, $target);
        }
    }

    /**
     * It is used to change the active working directory of PHP.
     * 
     * @param string $name
     * 
     * @return bool
     */
    public static function changeFolder(String $name) : Bool
    {
        $name = Info::rpath($name);

        if( ! is_dir($name) )
        {
            throw new FolderNotFoundException($name);
        }

        return chdir($name);
    }
    
}
