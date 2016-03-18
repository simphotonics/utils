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
     * Append to existing file when writing
     * to file.
     */
    const FILE_APPEND = 1;

    /**
     * Open new file when writing out content.
     */
    const FILE_NEW = 0;

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
    public static function write2file(
        $string,
        $filename,
        $mode = self::FILE_APPEND
    ) {
    
        if (is_dir($filename)) {
            throw new \RuntimeException("Error: $filename is a directory.");
        }
        
        if ($mode) {
            if (is_writeable($filename)) {
                return file_put_contents($filename, $string, FILE_APPEND);
            } else {
                throw new \RuntimeException(
                    "Error: Cannot append to $filename. 
                     The file is either non-existing or not writeable!"
                );
            }
        }
        // Check if directory is writable
        $dir = dirname($filename);
        if (is_writeable($dir)) {
            return file_put_contents($filename, $string, LOCK_EX);
        } else {
            throw new \RuntimeException("Directory: $dir is not writeable!");
        }
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
