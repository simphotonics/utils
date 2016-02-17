<?php
namespace Simphotonics\Utils;

/**
 * @author D Reschner <d.reschner@simphotonics.com>
 * @copyright 2015 Simphotonics
 * Description: File utility methods.
 */

class FileUtils
{
    /**
     * Asserts that a file exists and is readable.
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    public static function assertFileReadable($filename)
    {
        // Check file status
        if (!is_file($filename)) {
            throw new \RuntimeException("File: $filename not found!");
        }
        if (!is_readable($filename)) {
            throw new \RuntimeException(" File: $filename not readable or non existing!");
        }
        return true;
    }
    
    /**
     * Checks that filenames referenced in attribute array
     * point to existing, readable files.
     * @param  Array  $attr
     * @return bool
     */
    public static function assertRefFileReadable(array $attr)
    {
        $fileAttr = array('href', 'src');
        foreach ($fileAttr as $key) { // Scan each resource path
            if (isset($attr[$key])) {
                if (!self::assertFileExists($attr[$var])) {
                    throw new \RuntimeException("Attribute error! $key => $attr[$key]
                        File: $attr[$key] does not exist!");
                }
            }
        }
        return true;
    }

    /**
     * Export string to file.
     * @param  string $filename
     * @param  string $mode
     * @return 0    Exit code 1 on failure.
     */
    public static function write2file($string, $filename, $mode = 'append')
    {
        switch ($mode) {
            case 'overwrite':
                file_put_contents($filename, $string, LOCK_EX);
                break;
            default:
                file_put_contents($filename, $string, FILE_APPEND);
                break;
        }
    }

    public static function loadFile($fileName)
    {
        FileUtils::assertFileReadable($fileName);
        return  file_get_contents($fileName);
    }
}
