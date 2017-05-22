<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Images utilities.
 */
class Images
{

    /**
     * Returns the size of the image specified.
     * 
     * @param string $filename The filename of the image.
     * @throws \InvalidArgumentException
     * @return array[int,int] The size of the image specified.
     */
    public function getSize(string $filename): array
    {
        $filename = realpath($filename);
        if ($filename === false) {
            throw new \InvalidArgumentException('The filename specified does not exist');
        }
        try {
            $size = getimagesize($filename);
            if (is_array($size)) {
                return [(int) $size[0], (int) $size[1]];
            }
            $pathInfo = pathinfo($filename);
            if (isset($pathInfo['extension']) && $pathInfo['extension'] === 'webp' && function_exists('imagecreatefromwebp')) {
                $sourceImage = imagecreatefromwebp($filename);
                $result = [(int) imagesx($sourceImage), (int) imagesy($sourceImage)];
                imagedestroy($sourceImage);
                return $result;
            }
        } catch (\Exception $e) {
            $reason = $e->getMessage();
        }
        throw new \InvalidArgumentException('Cannot get size of ' . $filename . ' (reason: ' . (isset($reason) ? $reason : 'unknown') . ')');
    }

    /**
     * Resizes an image file.
     * 
     * @param string $sourceFilename The image file to resize.
     * @param string $destinationFilename The filename where the result image will be saved.
     * @param array $options Resize options. You can resize the file by providing "width", "height" or both.
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return void No value is returned.
     */
    public function resize(string $sourceFilename, string $destinationFilename, array $options = []): void
    {
        $sourceFilename = realpath($sourceFilename);
        if ($sourceFilename === false) {
            throw new \InvalidArgumentException('The sourceFilename specified does not exist');
        }
        if (isset($options['width']) && (!is_int($options['width']) || $options['width'] < 1 || $options['width'] > 100000)) {
            throw new \InvalidArgumentException('The width value must be higher than 0 and lower than 100001');
        }
        if (isset($options['height']) && (!is_int($options['height']) || $options['height'] < 1 || $options['height'] > 100000)) {
            throw new \InvalidArgumentException('The height value must be higher than 0 and lower than 100001');
        }
        $outputType = null;
        $sourcePathInfo = pathinfo($sourceFilename);
        $destinationPathInfo = pathinfo($destinationFilename);
        if (isset($destinationPathInfo['extension'])) {
            $extension = $destinationPathInfo['extension'];
            if ($extension === 'png') {
                $outputType = 'png';
            } elseif ($extension === 'gif') {
                $outputType = 'gif';
            } elseif ($extension === 'jpg' || $extension === 'jpeg') {
                $outputType = 'jpg';
            } elseif ($extension === 'webp') {
                $outputType = 'webp';
            }
        }
        if ($outputType !== 'png' && $outputType !== 'gif' && $outputType !== 'jpg' && $outputType !== 'webp') {
            throw new \InvalidArgumentException('The output format is not valid');
        }

        try {
            if (isset($sourcePathInfo['extension']) && $sourcePathInfo['extension'] === 'webp') {
                $sourceImageSize = $this->getSize($sourceFilename);
                $sourceImageWidth = $sourceImageSize[0];
                $sourceImageHeight = $sourceImageSize[1];
                $sourceImageMimeType = 'image/webp';
            } else {
                $sourceImageInfo = getimagesize($sourceFilename);
                if (!is_array($sourceImageInfo)) {
                    throw new \InvalidArgumentException('Cannot get source image size');
                }
                $sourceImageWidth = $sourceImageInfo[0];
                $sourceImageHeight = $sourceImageInfo[1];
                $sourceImageMimeType = $sourceImageInfo['mime'];
            }
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Unknown error (' . $e->getMessage() . ')');
        }

        $width = isset($options['width']) ? $options['width'] : null;
        $height = isset($options['height']) ? $options['height'] : null;

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

            $sourceImage = null;
            if ($sourceImageMimeType === 'image/jpeg' && function_exists('imagecreatefromjpeg')) {
                $sourceImage = imagecreatefromjpeg($sourceFilename);
            } elseif ($sourceImageMimeType === 'image/png' && function_exists('imagecreatefrompng')) {
                $sourceImage = imagecreatefrompng($sourceFilename);
            } elseif ($sourceImageMimeType === 'image/gif' && function_exists('imagecreatefromgif')) {
                $sourceImage = imagecreatefromgif($sourceFilename);
            } elseif ($sourceImageMimeType === 'image/webp' && function_exists('imagecreatefromwebp')) {
                $sourceImage = imagecreatefromwebp($sourceFilename);
            }

            if (!$sourceImage) {
                throw new \InvalidArgumentException('Cannot read the source image');
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
                    } elseif ($outputType == 'webp') {
                        $result = imagewebp($resultImage, $destinationFilename);
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
