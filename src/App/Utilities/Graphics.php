<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Utilities;

/**
 * Graphics utilities
 */
class Graphics
{

    /**
     * Return a image resource
     * @param string $sourceFileName The filename of the image
     * @throws \Exception
     * @return resource The image resource
     */
    static function getImage($sourceFileName)
    {
        if (!is_string($sourceFileName)) {
            throw new \InvalidArgumentException('');
        }
        $image = null;
        try {
            $image = imagecreatefromjpeg($sourceFileName);
        } catch (\Exception $e) {
            
        }
        if (!$image) {
            try {
                $image = imagecreatefrompng($sourceFileName);
            } catch (\Exception $e) {
                
            }
        }
        if (!$image) {
            try {
                $image = imagecreatefromgif($sourceFileName);
            } catch (\Exception $e) {
                
            }
        }
        if (!$image) {
            throw new \Exception('Invalid image file');
        }
        return $image;
    }

    /**
     * Returns the size of the image specified
     * @param string $sourceFileName The filename of the image
     * @throws \Exception
     * @return array The size of the image specified
     */
    static function getSize($sourceFileName)
    {
        if (!is_string($sourceFileName)) {
            throw new \InvalidArgumentException('');
        }
        $image = Graphics::getImage($sourceFileName);
        return array(imagesx($image), imagesy($image));
    }

    /**
     * Resizes a image file
     * @param string $sourceFileName The image file to resize
     * @param string $destinationFileName The filename where the result image will be saved
     * @param int $width The width of the resized image
     * @param int $height The height of the resized image
     * @param string $outputType The output type of the resized image
     * @return void No value is returned
     */
    static function resize($sourceFileName, $destinationFileName, $width, $height, $outputType = null)
    {
        if (!is_string($sourceFileName)) {
            throw new \InvalidArgumentException(' (sourceFileName)');
        }
        if (!is_string($destinationFileName)) {
            throw new \InvalidArgumentException(' (destinationFileName)');
        }
        if (!is_int($width) || $width < 1) {
            throw new \InvalidArgumentException(' (width)');
        }
        if (!is_int($height) || $height < 1) {
            throw new \InvalidArgumentException(' (height)');
        }
        if (is_string($outputType)) {
            $outputType = strtolower($outputType);
        }
        if ($outputType === 'jpeg') {
            $outputType = 'jpg';
        }
        $image = Graphics::getImage($sourceFileName);
        if ($outputType === null) {
            $pathInfo = pathinfo($destinationFileName);
            if (isset($pathInfo['extension'])) {
                $extension = $pathInfo['extension'];
                if ($extension === 'png') {
                    $outputType = 'png';
                } elseif ($extension === 'gif') {
                    $outputType = 'gif';
                } else {
                    $outputType = 'jpg';
                }
            }
        }
        if ($outputType !== 'png' && $outputType !== 'gif' && $outputType !== 'jpg' && $outputType !== 'ico') {
            throw new \InvalidArgumentException(' (outputType)');
        }
        try {
            $resultImage = imagecreatetruecolor($width, $height);
        } catch (\Exception $e) {
            $resultImage = false;
        }
        if ($resultImage !== false) {
            $imageWidth = imagesx($image);
            $imageHeight = imagesy($image);
            if ($imageWidth == $width && $imageHeight == $height) {
                copy($sourceFileName, $destinationFileName);
                imagedestroy($resultImage);
                return;
            }
            imagealphablending($resultImage, false);
            imagesavealpha($resultImage, true);
            imagefill($resultImage, 0, 0, imagecolorallocatealpha($resultImage, 0, 0, 0, 127));
            $widthRatio = $imageWidth / $width;
            $heightRatio = $imageHeight / $height;
            $resizedImageHeight = $height;
            $resizedImageWidth = $width;
            if ($widthRatio > $heightRatio) {
                $resizedImageWidth = ceil($imageWidth / $heightRatio);
            } else {
                $resizedImageHeight = ceil($imageHeight / $widthRatio);
            }
            $destinationX = - ($resizedImageWidth - $width) / 2;
            $destinationY = - ($resizedImageHeight - $height) / 2;

            if (imagecopyresampled($resultImage, $image, floor($destinationX), floor($destinationY), 0, 0, $resizedImageWidth, $resizedImageHeight, $imageWidth, $imageHeight)) {
                if ($outputType == 'jpg') {
                    if (imagejpeg($resultImage, $destinationFileName, 100)) {
                        imagedestroy($resultImage);
                        imagedestroy($image);
                        return;
                    }
                } elseif ($outputType == 'png') {
                    if (imagepng($resultImage, $destinationFileName, 9)) {
                        imagedestroy($resultImage);
                        imagedestroy($image);
                        return;
                    }
                } elseif ($outputType == 'gif') {
                    if (imagegif($resultImage, $destinationFileName)) {
                        imagedestroy($resultImage);
                        imagedestroy($image);
                        return;
                    }
                }
            }
            imagedestroy($resultImage);
        }
        imagedestroy($image);
    }

}
