<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Helper;

class File
{
    public static function createDirectory($path, $createIndexHtml = false)
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $path .= DIRECTORY_SEPARATOR;

        if (file_exists($path) && is_dir($path))
        {
            return true;
        }

        $path = str_replace('\\', '/', $path);
        $path = rtrim($path, '/');
        $parts = explode('/', $path);
        $pathPartCount = count($parts);
        $partialPath = '';

        $rootDir = \App::getRegistry()->get('rootDir');

        // find the "lowest" part that exists (and is a dir)...
        for ($i = $pathPartCount - 1; $i >= 0; $i--)
        {
            $partialPath = implode('/', array_slice($parts, 0, $i + 1));
            if ($partialPath == $rootDir)
            {
                return false; // can't go above the root dir
            }

            if (file_exists($partialPath))
            {
                if (!is_dir($partialPath))
                {
                    return false;
                }
                else
                {
                    break;
                }
            }
        }
        if ($i < 0)
        {
            return false;
        }

        $i++; // skip over the last entry (as it exists)

        // ... now create directories for anything below it
        for (; $i < $pathPartCount; $i++)
        {
            $partialPath .= '/' . $parts[$i];
            if (!file_exists($partialPath))
            {
                try
                {
                    if (!mkdir($partialPath))
                    {
                        return false;
                    }
                }
                catch (\Exception $e)
                {
                    if (strpos($e->getMessage(), 'File exists') !== false)
                    {
                        // this means the directory already exists - race condition, we're ok
                    }
                    else
                    {
                        throw $e;
                    }
                }
            }

            if ($createIndexHtml)
            {
                $fp = @fopen($partialPath . '/index.html', 'w');
                if ($fp)
                {
                    fwrite($fp, ' ');
                    fclose($fp);
                }
            }
        }

        return true;
    }

    public static function getFileExtension($filename)
    {
        return strtolower(substr(strrchr($filename, '.'), 1));
    }
}