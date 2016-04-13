<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Images utilities
 */
class Images
{

    /**
     * Returns the size of the image specified
     * @param string $filename The filename of the image
     * @throws \InvalidArgumentException
     * @return array[int, int] The size of the image specified
     */
    public function getSize($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        try {
            $size = getimagesize($filename);
            if (is_array($size)) {
                return [(int) $size[0], (int) $size[1]];
            }
        } catch (\Exception $e) {
            
        }
        throw new \InvalidArgumentException('');
    }

    /**
     * Resizes a image file
     * @param string $sourceFilename The image file to resize
     * @param string $destinationFilename The filename where the result image will be saved
     * @param array $options Resize options. You can resize the file by providing "width", "height" or both.
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return void No value is returned
     */
    public function resize($sourceFilename, $destinationFilename, $options = [])
    {
        if (!is_string($sourceFilename)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_string($destinationFilename)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        if (isset($options['width']) && (!is_int($options['width']) || $options['width'] < 1 || $options['width'] > 100000)) {
            throw new \InvalidArgumentException('');
        }
        if (isset($options['height']) && (!is_int($options['height']) || $options['height'] < 1 || $options['height'] > 100000)) {
            throw new \InvalidArgumentException('');
        }
        $outputType = null;
        $pathInfo = pathinfo($destinationFilename);
        if (isset($pathInfo['extension'])) {
            $extension = $pathInfo['extension'];
            if ($extension === 'png') {
                $outputType = 'png';
            } elseif ($extension === 'gif') {
                $outputType = 'gif';
            } elseif ($extension === 'jpg' || $extension === 'jpeg') {
                $outputType = 'jpg';
            }
        }
        if ($outputType !== 'png' && $outputType !== 'gif' && $outputType !== 'jpg') {
            throw new \InvalidArgumentException('');
        }
        if (!is_file($sourceFilename)) {
            throw new \InvalidArgumentException('');
        }

        try {
            $sourceImageInfo = getimagesize($sourceFilename);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('');
        }

        $width = isset($options['width']) ? $options['width'] : null;
        $height = isset($options['height']) ? $options['height'] : null;

        $sourceImageWidth = $sourceImageInfo[0];
        $sourceImageHeight = $sourceImageInfo[1];

        if ($width === null && $height === null) {
            $width = $sourceImageWidth;
            $height = $sourceImageHeight;
        } elseif ($width === null && $height !== null) {
            $width = (int) floor($sourceImageWidth / $sourceImageHeight * $height);
        } elseif ($height === null && $width !== null) {
            $height = (int) floor($sourceImageHeight / $sourceImageWidth * $width);
        }

        if ($sourceImageWidth === $width && $sourceImageHeight === $height) {
            copy($sourceFilename, $destinationFilename);
        } else {
            $sourceImageMimeType = $sourceImageInfo['mime'];

            $sourceImage = null;
            if ($sourceImageMimeType === 'image/jpeg' && function_exists('imagecreatefromjpeg')) {
                $sourceImage = imagecreatefromjpeg($sourceFilename);
            } elseif ($sourceImageMimeType === 'image/png' && function_exists('imagecreatefrompng')) {
                $sourceImage = imagecreatefrompng($sourceFilename);
            } elseif ($sourceImageMimeType === 'image/gif' && function_exists('imagecreatefromgif')) {
                $sourceImage = imagecreatefromgif($sourceFilename);
            }

            if (!$sourceImage) {
                throw new \InvalidArgumentException('');
            }
            $result = false;
            try {
                $resultImage = imagecreatetruecolor($width, $height);
                imagealphablending($resultImage, false);
                imagesavealpha($resultImage, true);
                imagefill($resultImage, 0, 0, imagecolorallocatealpha($resultImage, 0, 0, 0, 127));
                $widthRatio = $sourceImageWidth / $width;
                $heightRatio = $sourceImageHeight / $height;
                $resizedImageHeight = $height;
                $resizedImageWidth = $width;
                if ($widthRatio > $heightRatio) {
                    $resizedImageWidth = ceil($sourceImageWidth / $heightRatio);
                } else {
                    $resizedImageHeight = ceil($sourceImageHeight / $widthRatio);
                }
                $destinationX = - ($resizedImageWidth - $width) / 2;
                $destinationY = - ($resizedImageHeight - $height) / 2;

                if (imagecopyresampled($resultImage, $sourceImage, floor($destinationX), floor($destinationY), 0, 0, $resizedImageWidth, $resizedImageHeight, $sourceImageWidth, $sourceImageHeight)) {
                    if ($outputType == 'jpg') {
                        $result = imagejpeg($resultImage, $destinationFilename, 100);
                    } elseif ($outputType == 'png') {
                        $result = imagepng($resultImage, $destinationFilename, 9);
                    } elseif ($outputType == 'gif') {
                        $result = imagegif($resultImage, $destinationFilename);
                    }
                }
                imagedestroy($resultImage);
            } catch (\Exception $e) {
                
            }
            imagedestroy($sourceImage);
            if (!$result) {
                throw new \Exception('');
            }
        }
    }

}
