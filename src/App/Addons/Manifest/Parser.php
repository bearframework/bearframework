<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Addons\Manifest;

class Parser
{

    /**
     * 
     * @param string $content
     * @throws \Exception
     * @return App\Addons\Manifest
     */
    static function parse($content)
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('');
        }
        try {
            $parsedData = json_decode($content, true);
        } catch (\Exception $e) {
            $parsedData = null;
        }

        if (!is_array($parsedData)) {
            throw new Exception('manifest data is not valid');
        }

        $manifest = new \App\Addons\Manifest();

        if (isset($parsedData['id'])) {
            $manifest->id = trim((string) $parsedData['id']);
            if (strlen($manifest->id) === 0) {
                throw new Exception('id is not valid');
            }
        } else {
            throw new Exception('id is required');
        }

        if (isset($parsedData['version'])) {
            $manifest->version = trim((string) $parsedData['version']);
            if (preg_match('/^[0-9]+\.[0-9]+\.[0-9]+(\-alpha|\-beta){0,1}$/', $manifest->version) === 0) {
                throw new Exception('version is not valid');
            }
        }

        if (isset($parsedData['name'])) {
            $manifest->name = trim((string) $parsedData['name']);
            if (strlen($manifest->name) === 0) {
                throw new Exception('name is not valid');
            }
        } else {
            throw new Exception('name is required');
        }

        if (isset($parsedData['description'])) {
            $manifest->description = trim((string) $parsedData['description']);
        }

        if (isset($parsedData['updateUrl'])) {
            $manifest->updateUrl = trim((string) $parsedData['updateUrl']);
        }

        if (isset($parsedData['authors'])) {
            if (is_array($parsedData['authors'])) {
                foreach ($parsedData['authors'] as $authorData) {
                    $author = new \App\Addons\Manifest\Author();
                    $author->name = isset($authorData['name']) ? trim((string) $authorData['name']) : '';
                    $author->website = isset($authorData['website']) ? trim((string) $authorData['website']) : '';
                    $author->email = isset($authorData['email']) ? trim((string) $authorData['email']) : '';
                    $manifest->authors[] = $author;
                }
            }
        }

        if (isset($parsedData['media'])) {
            if (is_array($parsedData['media'])) {
                foreach ($parsedData['media'] as $mediaData) {
                    if (is_array($mediaData) && isset($mediaData['src'], $mediaData['width'], $mediaData['height'])) {
                        $media = new \App\Addons\Manifest\Media();
                        $media->src = trim((string) $mediaData['src']);
                        if (strlen($media->src) === 0) {
                            throw new Exception('media is not valid');
                        }
                        $media->width = (int) $mediaData['width'];
                        if ($media->width <= 0) {
                            throw new Exception('media is not valid');
                        }
                        $media->height = (int) $mediaData['height'];
                        if ($media->height <= 0) {
                            throw new Exception('media is not valid');
                        }
                        $manifest->media[] = $media;
                    } else {
                        throw new Exception('media is not valid');
                    }
                }
            } else {
                throw new Exception('media is not valid');
            }
        }

        if (isset($parsedData['options'])) {
            if (is_array($parsedData['options'])) {
                foreach ($parsedData['options'] as $optionData) {
                    if (is_array($optionData) && isset($optionData['id'])) {
                        $option = new \App\Addons\Manifest\Option();
                        $option->id = trim((string) $optionData['id']);
                        if (strlen($option->id) === 0) {
                            throw new Exception('options are not valid');
                        }
                        $option->type = isset($optionData['type']) ? trim((string) $optionData['type']) : '';
                        $option->name = isset($optionData['name']) ? trim((string) $optionData['name']) : '';
                        $option->description = isset($optionData['description']) ? trim((string) $optionData['description']) : '';

                        if (isset($optionData['validations'])) {
                            if (is_array($optionData['validations'])) {
                                foreach ($optionData['validations'] as $validationData) {
                                    if (is_array($validationData) && isset($validationData['id'])) {
                                        $validation = new \App\Addons\Manifest\OptionValidation();
                                        $validation->type = isset($validation['type']) ? trim((string) $validationData['type']) : '';
                                        $validation->text = isset($validation['text']) ? trim((string) $validationData['text']) : '';
                                        $validation->data = isset($validation['data']) ? $validationData['data'] : null;
                                        $option->validations[] = $validation;
                                    }
                                }
                            }
                        }
                        $manifest->options[] = $option;
                    } else {
                        throw new Exception('media is not valid');
                    }
                }
            } else {
                throw new Exception('options are not valid');
            }
        }

        return $manifest;
    }

}
