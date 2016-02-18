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
     * @param  string $filename File path.
     * @return bool             Returns true on success.
     */
    public static function assertFileReadable($filename)
    {
        // Check file status
        if (!is_file($filename)) {
            throw new \RuntimeException("File: $filename not found!");
        }
        if (!is_readable($filename)) {
            throw new \RuntimeException(" File: $filename not readable!");
        }
        return true;
    }
    
    /**
     * Export string to file.
     * @param  string $filename
     * @param  string $mode
     * @return int  Number of bites written.
     *
     * @throws \RuntimeException if file is not existing or writable.
     */
    public static function write2file($string, $filename, $mode = 'append')
    {
        if (!is_writeable($filename) or is_dir($filename)) {
            throw \RuntimeException("File $filename is not writable.");
        }
        if ($mode === 'append') {
            return file_put_contents($filename, $string, FILE_APPEND);
        }
        return file_put_contents($filename, $string, LOCK_EX);
    }


    /**
     * Imports file content.
     * @param  string $fileName  File path.
     * @return string            File content.
     */
    public static function loadFile($fileName)
    {
        FileUtils::assertFileReadable($fileName);
        return  file_get_contents($fileName);
    }
}
