<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Helper;

class Image
{
    const ORIENTATION_LANDSCAPE = 'landscape';
    const ORIENTATION_PORTRAIT = 'portrait';
    const ORIENTATION_SQUARE = 'square';

    const FLIP_HORIZONTAL = 1;
    const FLIP_VERTICAL = 2;
    const FLIP_BOTH = 3;

    protected $_width = 0;

    protected $_height = 0;

    protected $_image = null;

    /**
     * Constructor.
     *
     * @param resource $image GD image resource
     */
    protected function __construct($image)
    {
        $this->_setImage($image);
    }

    /**
     * Creates a blank image.
     *
     * @param integer $width
     * @param integer $height
     *
     * @return Image
     */
    public static function createImageDirect($width, $height)
    {
        return new self(imagecreatetruecolor($width, $height));
    }

    /**
     * Creates an image from an existing file.
     *
     * @param string $fileName
     * @param integer $inputType IMAGETYPE_XYZ constant representing image type
     *
     * @return Image|false
     */
    public static function createFromFileDirect($fileName, $inputType)
    {
        $invalidType = false;

        try
        {
            switch ($inputType)
            {
                case IMAGETYPE_GIF:
                    if (!function_exists('imagecreatefromgif'))
                    {
                        return false;
                    }
                    $image = imagecreatefromgif($fileName);
                    break;

                case IMAGETYPE_JPEG:
                    if (!function_exists('imagecreatefromjpeg'))
                    {
                        return false;
                    }
                    $image = imagecreatefromjpeg($fileName);
                    break;

                case IMAGETYPE_PNG:
                    if (!function_exists('imagecreatefrompng'))
                    {
                        return false;
                    }
                    $image = imagecreatefrompng($fileName);
                    break;

                default:
                    $invalidType = true;
            }
        }
        catch (\Exception $e)
        {
            return false;
        }

        if ($invalidType)
        {
            throw new \Exception('Invalid image type given. Expects IMAGETYPE_XXX constant.');
        }

        return new self($image);
    }

    /**
     * Thumbnails the image.
     *
     * @see XenForo_Image_Abstract::thumbnail()
     */
    public function thumbnail($maxWidth, $maxHeight = 0)
    {
        if ($maxWidth < 10)
        {
            $maxWidth = 10;
        }
        if ($maxHeight < 10)
        {
            $maxHeight = $maxWidth;
        }

        if ($this->_width < $maxWidth && $this->_height < $maxHeight)
        {
            return false;
        }

        $ratio = $this->_width / $this->_height;

        $maxRatio = ($maxWidth / $maxHeight);

        if ($maxRatio > $ratio)
        {
            $width = max(1, $maxHeight * $ratio);
            $height = $maxHeight;
        }
        else
        {
            $width = $maxWidth;
            $height = max(1, $maxWidth / $ratio);
        }

        $newImage = imagecreatetruecolor($width, $height);
        $this->_preallocateBackground($newImage);

        imagecopyresampled(
            $newImage, $this->_image,
            0, 0, 0, 0,
            $width, $height, $this->_width, $this->_height
        );
        $this->_setImage($newImage);

        return true;
    }

    /**
     * Produces a thumbnail of the current image whose shorter side is the specified length
     *
     * @see XenForo_Image_Abstract::thumbnailFixedShorterSide
     */
    public function thumbnailFixedShorterSide($shortSideLength)
    {
        if ($shortSideLength < 10)
        {
            $shortSideLength = 10;
        }

        $ratio = $this->_width / $this->_height;
        if ($ratio > 1) // landscape
        {
            $width = $shortSideLength * $ratio;
            $height = $shortSideLength;
        }
        else
        {
            $width = $shortSideLength;
            $height = max(1, $shortSideLength / $ratio);
        }

        $newImage = imagecreatetruecolor($width, $height);
        $this->_preallocateBackground($newImage);

        imagecopyresampled(
            $newImage, $this->_image,
            0, 0, 0, 0,
            $width, $height, $this->_width, $this->_height);
        $this->_setImage($newImage);
    }

    /**
     * Crops the image.
     *
     * @see XenForo_Image_Abstract::crop()
     */
    public function crop($x, $y, $width, $height)
    {
        $newImage = imagecreatetruecolor($width, $height);
        $this->_preallocateBackground($newImage);

        imagecopyresampled(
            $newImage, $this->_image,
            0, 0, $x, $y,
            $width, $height, $width, $height
        );
        $this->_setImage($newImage);
    }

    /**
     * Rotates the image clockwise
     *
     * @see XenForo_Image_Abstract::rotate()
     */
    public function rotate($angle)
    {
        $newImage = imagerotate($this->_image, $angle * -1, 0);

        $this->_setImage($newImage);
    }

    /**
     * Flips the image
     *
     * @see XenForo_Image_Abstract::flip()
     */
    public function flip($mode)
    {
        $srcX = 0;
        $srcY = 0;
        $srcWidth = $this->_width;
        $srcHeight = $this->_height;

        switch ($mode)
        {
            case self::FLIP_HORIZONTAL:
                $srcX = $this->_width - 1;
                $srcWidth = -$this->_width;
                break;

            case self::FLIP_VERTICAL:
                $srcY = $this->_height - 1;
                $srcHeight = -$this->_height;
                break;

            case self::FLIP_BOTH:
                $srcX = $this->_width - 1;
                $srcWidth = -$this->_width;
                $srcY = $this->_height - 1;
                $srcHeight = -$this->_height;
                break;

            default:
                return;
        }

        $newImage = imagecreatetruecolor($this->_width, $this->_height);
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        imagecopyresampled(
            $newImage, $this->_image,
            0, 0, $srcX, $srcY,
            $this->_width, $this->_height, $srcWidth, $srcHeight
        );

        $this->_setImage($newImage);
    }

    /**
     * Outputs the image.
     *
     * @see XenForo_Image_Abstract::output()
     */
    public function output($outputType, $outputFile = null, $quality = 85)
    {
        switch ($outputType)
        {
            case IMAGETYPE_GIF: $success = imagegif($this->_image, $outputFile); break;
            case IMAGETYPE_JPEG: $success = imagejpeg($this->_image, $outputFile, $quality); break;
            case IMAGETYPE_PNG:
                imagealphablending($this->_image, false);
                imagesavealpha($this->_image, true);

                // "quality" seems to be misleading, always force 9
                $success = imagepng($this->_image, $outputFile, 9, PNG_ALL_FILTERS);
                break;

            default:
                throw new \Exception('Invalid output type given. Expects IMAGETYPE_XXX constant.');
        }

        return $success;
    }

    protected function _preallocateBackground($image)
    {
        imagesavealpha($image, true);
        $color = imagecolorallocatealpha($image, 255, 255, 255, 127);
        imagefill($image, 0, 0, $color);
    }

    /**
     * Sets the internal GD image resource.
     *
     * @param resource $image
     */
    protected function _setImage($image)
    {
        $this->_image = $image;
        $this->_width = imagesx($image);
        $this->_height = imagesy($image);
    }

    public function getOrientation()
    {
        $w = $this->getWidth();
        $h = $this->getHeight();

        if ($w == $h)
        {
            return self::ORIENTATION_SQUARE;
        }
        else if ($w > $h)
        {
            return self::ORIENTATION_LANDSCAPE;
        }
        else
        {
            return self::ORIENTATION_PORTRAIT;
        }
    }

    public function getWidth()
    {
        return $this->_width;
    }

    public function getHeight()
    {
        return $this->_height;
    }

    public function transformByExif($orientation)
    {
        $transforms = array(
            2 => 'flip-h',
            3 => 180,
            4 => 'flip-v',
            5 => 'transpose',
            6 => 90,
            7 => 'transverse',
            8 => 270
        );

        if (isset($transforms[$orientation]))
        {
            $transform = $transforms[$orientation];
            switch ($transform)
            {
                case 'flip-h':
                    $this->flip(self::FLIP_HORIZONTAL);
                    break;

                case 'flip-v':
                    $this->flip(self::FLIP_VERTICAL);
                    break;

                case 'transpose':
                    $this->rotate(90);
                    $this->flip(self::FLIP_HORIZONTAL);
                    break;

                case 'transverse':
                    $this->rotate(90);
                    $this->flip(self::FLIP_VERTICAL);
                    break;

                default:
                    if (is_int($transform))
                    {
                        $this->rotate($transform);
                    }
                    else
                    {
                        throw new \Exception('Invalid transform: ' . $transform);
                    }
            }
        }
    }
}