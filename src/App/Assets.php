<?php

namespace App;

class Assets
{

    /**
     * 
     * @param string $path
     * @return boolean|string
     */
    function getFilename($path)
    {
        global $app;
        if ($app->config->assetsPathPrefix === null) {
            throw new \Exception('');
        }
        $path = substr($path, strlen($app->config->assetsPathPrefix));
        $partParts = explode('/', $path, 2);
        $hash = substr($partParts[0], 0, 10);
        $type = substr($partParts[0], 10, 1);
        $optionsString = (string) substr($partParts[0], 11);
        $path = $partParts[1];
        if ($type === 'a') {
            $addonsDir = $app->config->addonsDir;
            if (strlen($addonsDir) === 0) {
                throw new Exception('');
            }
            $filename = $addonsDir . $path;
        } elseif ($type === 'p') {
            $filename = $app->config->appDir . $path;
        } elseif ($type === 'd') {
//            if (!$app->data->isPublic($path)) {
//                return false;
//            }
            $filename = $app->config->dataDir . 'objects/' . $path;
        } else {
            return false;
        }
        if ($hash === substr(md5(md5($filename) . md5($optionsString)), 0, 10)) {
            if (is_file($filename)) {
                if ($optionsString === '') {
                    return $filename;
                } else {
                    $pathinfo = pathinfo($filename);
                    if (isset($pathinfo['extension'])) {
                        $tempFilename = $app->config->dataDir . 'objects/.temp/assets/' . md5(md5($filename) . md5($optionsString));
                        if (!is_file($tempFilename)) {
                            $options = explode('-', $optionsString);
                            $width = null;
                            $height = null;
                            foreach ($options as $option) {
                                if (substr($option, 0, 1) === 'w') {
                                    $value = (int) substr($option, 1);
                                    if ($value >= 1 && $value <= 100000) {
                                        $width = $value;
                                    }
                                }
                                if (substr($option, 0, 1) === 'h') {
                                    $value = (int) substr($option, 1);
                                    if ($value >= 1 && $value <= 100000) {
                                        $height = $value;
                                    }
                                }
                            }
                            if ($width === null && $height === null) {
                                return false;
                            }
                            if ($width === null) {
                                $imageSize = \App\Utilities\Graphics::getSize($filename);
                                $width = (int) floor($imageSize[0] / $imageSize[1] * $height);
                            } elseif ($height === null) {
                                $imageSize = \App\Utilities\Graphics::getSize($filename);
                                $height = (int) floor($imageSize[1] / $imageSize[0] * $width);
                            }
                            \App\Utilities\File::makeDir($tempFilename);
                            \App\Utilities\Graphics::resize($filename, $tempFilename, $width, $height, $pathinfo['extension']);
                        }
                        return $tempFilename;
                    }
                }
            }
        }
        return false;
    }

    /**
     * 
     * @param string $filename
     * @param array $options
     * @return string
     * @throws \InvalidArgumentException
     */
    function getUrl($filename, $options = [])
    {
        // todo extension check za width
        global $app;
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        $optionsString = '';
        ksort($options);
        foreach ($options as $name => $value) {
            if ($name === 'width' || $name === 'height') {
                $value = (int) $value;
                if ($value < 1) {
                    $value = 1;
                } elseif ($value > 100000) {
                    $value = 100000;
                }
                $optionsString .= ($name === 'width' ? 'w' : 'h') . $value . '-';
            }
        }
        $optionsString = trim($optionsString, '-');
        $hash = substr(md5(md5($filename) . md5($optionsString)), 0, 10);
        $addonsDir = $app->config->addonsDir;
        if (strlen($addonsDir) > 0 && strpos($filename, $addonsDir) === 0) {
            if (strpos($filename, '/assets/') === false) {
                throw new \InvalidArgumentException('Addon asset files must be in ' . $addonsDir . 'addon-name/assets/ or ' . $addonsDir . 'addon-name/*/assets/ directory. This it the only addon directory with public access.');
            }
            return $app->request->base . $app->config->assetsPathPrefix . $hash . 'a' . $optionsString . '/' . substr($filename, 10);
        }
        if (strpos($filename, $app->config->appDir) === 0) {
            if (strpos($filename, '/assets/') === false) {
                throw new \InvalidArgumentException('App asset files must be in ' . $app->config->appDir . 'assets/ or ' . $app->config->appDir . '*/assets/ directory. This it the only addon directory with public access.');
            }
            return $app->request->base . $app->config->assetsPathPrefix . $hash . 'p' . $optionsString . '/' . substr($filename, 7);
        }
        if (strpos($filename, $app->config->dataDir) === 0) {
            return $app->request->base . $app->config->assetsPathPrefix . $hash . 'd' . $optionsString . '/' . substr($filename, 8 + 8);
        }
        throw new \InvalidArgumentException('');
    }

    /**
     * 
     * @global \BearFramework\App $app
     * @param string $filename
     * @return array
     * @throws \InvalidArgumentException
     */
    function getDimensions($filename)
    {
        global $app;
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        $cacheKey = 'asset-dimensions-' . $filename;
        $data = $app->cache->get($cacheKey);
        if ($data === false) {
            try {
                $data = getimagesize($filename);
            } catch (\Exception $e) {
                $data = null;
            }
            $app->cache->set($cacheKey, $data, is_array($data) ? 0 : 10);
        }

        if (is_array($data) && isset($data[0]) && isset($data[1]) && is_int($data[0]) && is_int($data[1])) {
            return [$data[0], $data[1]];
        } else {
            throw new \InvalidArgumentException('File path not valid image');
        }
    }

    /**
     * 
     * @param string $filename
     * @return string|null
     */
    function getMimeType($filename)
    {
        $pathinfo = pathinfo($filename);
        if (isset($pathinfo['extension'])) {
            $extension = $pathinfo['extension'];
            if ($extension === 'jpg' || $extension === 'jpeg') {
                return 'image/jpeg';
            } elseif ($extension === 'png') {
                return 'image/png';
            } elseif ($extension === 'gif') {
                return 'image/gif';
            }
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filename);
        finfo_close($finfo);
        return $mimeType !== false ? $mimeType : null;
    }

}
