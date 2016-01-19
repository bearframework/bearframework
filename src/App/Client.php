<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

class Client
{

    /**
     * 
     */
    static function update()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        self::updateFramework();
        self::updateAddons();
    }

    /**
     * 
     * @throws \Exception
     */
    static function updateAddons()
    {
        $addonsDir = $app->config->addonsDir;
        if (strlen($addonsDir) === 0) {
            return false;
        }
        if (is_dir($addonsDir)) {
            $list = scandir($addonsDir);
            if (is_array($list)) {
                foreach ($list as $filename) {
                    if ($filename != '.' && $filename != '..' && is_dir($addonsDir . $filename)) {
                        $addonID = strtolower($filename);
                        $filename = $app->config->addonsDir . $addonID . '/manifest.json';
                        if (is_file($filename) && is_readable($filename)) {
                            self::updateAddon($addonID);
                        }
                    }
                }
            }
        }
    }

    /**
     * 
     * @throws \Exception
     */
    static function updateFramework()
    {
        $app = &\App::$instance;
        //self::writeLog(['updateFramework', $currentVersion]);
        $latestReleaseData = self::getLatestReleaseData('http://dev/playground/addons/framework/releases.json');
        if (version_compare($app::VERSION, $latestReleaseData['version']) === -1) {
            if (isset($latestReleaseData['id']) && $latestReleaseData['id'] === 'bearframework') {
                try {
                    self::checkRequirements($latestReleaseData);

                    foreach ($latestReleaseData['files'] as $filename => $encodedContent) {
                        if (!self::isFileWritable('../bearframwork/' . $filename)) {
                            //log
                            return false;
                        }
                    }
                    foreach ($latestReleaseData['files'] as $filename => $encodedContent) {
                        self::writeEncodedFile('../bearframwork/' . $filename, $encodedContent);
                    }
                    self::clearFilesCache();

                    return true;
                } catch (\Exception $e) {
                    //log
                    return false;
                }
            } else {
                //self::writeLog(['updateFramework', 'error', 'id not valid']);
                return false;
            }
        } else {
            //log
            return false;
        }
    }

    /**
     * 
     * @param string $url
     * @return string addonID
     */
    static function addAddonFromUrl($url)
    {
        //self::writeLog(['writeAddon']);
        try {
            $versionData = self::getLatestReleaseData($url);
        } catch (\Exception $dontCareException) {
            $sourceContent = self::makeRequest($url);
            $versionData = json_decode($sourceContent, true);
        }
        return self::addAddon($versionData);
    }

    /**
     * 
     * @param string $source
     * @return string addonID
     */
    static function addAddonFromSource($source)
    {
        //self::writeLog(['writeAddon']);
        $versionData = json_decode($source, true);
        return self::addAddon($versionData);
    }

    /**
     * 
     * @param array $versionData
     * @return string addonID
     * @throws \Exception
     */
    static function addAddon($versionData)
    {
        if (is_array($versionData) && isset($versionData['id']) && is_string($versionData['id'])) {
            $addonID = $versionData['id'];
            self::updateAddonFiles($addonID, $versionData);
            //self::writeLog(['writeAddon', $addonID, (isset($versionData['version']) ? $versionData['version'] : 'undefined')]);
            return $addonID;
        } else {
            //self::writeLog(['writeAddon', 'error', 'Invalid addon data']);
            throw new \Exception('Invalid addon data');
        }
    }

    /**
     * 
     * @param string $id
     * @return boolean
     */
    static function updateAddon($id)
    {
        $app = &\App::$instance;
        //self::writeLog(['updateAddon', $id]);
        $filename = $app->config->addonsDir . $id . '/manifest.json';
        if (is_file($filename)) {
            $manifestData = json_decode(file_get_contents($filename), true);
            if (isset($manifestData['updateUrl'])) {
                $latestReleaseData = self::getLatestReleaseData((string) $manifestData['updateUrl']);
                $currentVersionData = $app->addons->getManifest($id);
                if ($currentVersionData->id === $latestReleaseData['id']) {
                    if (version_compare($currentVersionData->version, $latestReleaseData['version']) === -1) {
                        try {
                            self::updateAddonFiles($id, $latestReleaseData);
                            //log
                            return true;
                        } catch (\Exception $e) {
                            //log
                            return false;
                        }
                    } else {
                        //log
                        return false;
                    }
                } else {
                    //self::writeLog(['updateAddon', 'error', 'id not valid']);
                    return false;
                }
            }
        }
        return false;
    }

    /**
     * 
     * @param string $id
     * @param array $versionData
     * @return boolean
     * @throws \Exception
     */
    static function updateAddonFiles($id, $versionData)
    {
        try {
            self::checkRequirements($versionData);
        } catch (\Exception $e) {
            //log
            return false;
        }
        $addonsDir = $app->config->addonsDir;
        if (strlen($addonsDir) === 0) {
            return false;
        }
        $dir = $addonsDir . $id . '/';
        if (isset($versionData['files'])) {
            foreach ($versionData['files'] as $filename => $encodedContent) {
                if (!self::isFileWritable($dir . $filename)) {
                    throw new \Exception('Cant write ' . $dir . $filename);
                }
            }
            foreach ($versionData['files'] as $filename => $encodedContent) {
                self::writeEncodedFile($dir . $filename, $encodedContent);
            }
            self::clearFilesCache();
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param array $versionData
     * @throws \Exception
     */
    static function checkRequirements($versionData)
    {
        if (isset($versionData['requirements'])) {
            if (isset($versionData['requirements']['phpFunctions'])) {
                $missingPhpFunctions = array();
                foreach ($versionData['requirements']['phpFunctions'] as $phpFunctionName) {
                    if (!function_exists($phpFunctionName)) {
                        $missingPhpFunctions[] = $phpFunctionName;
                    }
                }
                if (!empty($missingPhpFunctions)) {
                    if (sizeof($missingPhpFunctions) === 1) {
                        throw new \Exception('The following php function is missing (1008) - ' . $missingPhpFunctions[0]);
                    } else {
                        throw new \Exception('The following php functions are missing (1008) - ' . implode(', ', $missingPhpFunctions));
                    }
                }
            }
            if (isset($versionData['requirements']['phpClasses'])) {
                $missingPhpClasses = array();
                foreach ($versionData['requirements']['phpClasses'] as $phpClassName) {
                    if (!class_exists($phpClassName)) {
                        $missingPhpClasses[] = $phpClassName;
                    }
                }
                if (!empty($missingPhpClasses)) {
                    if (sizeof($missingPhpClasses) === 1) {
                        throw new \Exception('The following php class is missing (1008) - ' . $missingPhpClasses[0]);
                    } else {
                        throw new \Exception('The following php classes are missing (1008) - ' . implode(', ', $missingPhpClasses));
                    }
                }
            }
            if (isset($versionData['requirements']['apacheModules'])) {
                if (function_exists('apache_get_modules') && is_callable('apache_get_modules')) {
                    $apacheModules = apache_get_modules();
                    $missingApacheModules = array_diff($versionData['requirements']['apacheModules'], $apacheModules);
                    if (!empty($missingApacheModules)) {
                        if (sizeof($missingApacheModules) === 1) {
                            throw new \Exception('The following apache module must be enabled (1008) - ' . $missingApacheModules[0]);
                        } else {
                            throw new \Exception('The following apache modules must be enabled (1008) - ' . implode(', ', $missingApacheModules));
                        }
                    }
                }
            }
        }
        if (!isset($versionData['files'])) {
            throw new \Exception('Missing files');
        }
    }

    /**
     * 
     * @param string $releasesUrl
     * @return array
     * @throws Exception
     * @throws \Exception
     */
    static function getLatestReleaseData($releasesUrl)
    {
        $enabledChannels = ['stable', 'beta', 'alpha']; //todo
        $releases = json_decode(self::makeRequest($releasesUrl), true);
        $versionsUrl = [];
        if (is_array($releases)) {
            foreach ($releases as $release) {
                if (isset($release['version'], $release['url']) && is_string($release['version']) && is_string($release['url'])) {
                    $version = $release['version'];
                    $channel = 'stable';
                    if (strpos($version, 'alpha') !== false) {
                        $channel = 'alpha';
                        $version = str_replace('alpha', '', $version);
                    } elseif (strpos($version, 'beta') !== false) {
                        $channel = 'beta';
                        $version = str_replace('beta', '', $version);
                    }
                    $version = trim($version);
                    if (array_search($channel, $enabledChannels) === false) {
                        continue;
                    }

                    $versionsUrl[] = ['version' => $version, 'url' => $release['url']];
                }
            }
        }
        if (empty($versionsUrl)) {
            throw new \Exception('Cant find latest version');
        }

        usort($versionsUrl, function ($a, $b) {
            return version_compare($a['version'], $b['version']) * -1;
        });
        $latestVersion = $versionsUrl[0]['version'];
        $latestReleaseUrl = $versionsUrl[0]['url'];

        $tempFilePath = $app->config->dataDir . 'objects/.temp/installers/' . md5(md5($releasesUrl) . md5($latestVersion) . md5($latestReleaseUrl)) . '.json';
        if (is_file($tempFilePath)) {
            $versionData = json_decode(file_get_contents($tempFilePath), true);
            if (is_array($versionData) && isset($versionData['id'], $versionData['version']) && (string) $versionData['version'] === (string) $latestVersion) {
                return $versionData;
            }
        }

        $sourceContent = self::makeRequest($latestReleaseUrl);
        $versionData = json_decode($sourceContent, true);
        if (is_array($versionData) && isset($versionData['id'], $versionData['version']) && (string) $versionData['version'] === (string) $latestVersion) {
            self::writeFile($tempFilePath, $sourceContent);
            return $versionData;
        } else {
            throw new \Exception('Invalid version in the downloaded source');
        }
    }

    /**
     * 
     * @param string $url
     * @return string
     * @throws \Exception
     */
    static function makeRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $responseHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseHeaderSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);
        if (isset($error{0})) {
            throw new \Exception('Curl error: ' . $error . ' (1027)');
        }
        if ((int) $responseHttpCode !== 200) {
            throw new \Exception('Request failed (1006)');
        }
        return (string) substr($response, $responseHeaderSize);
    }

    /**
     * 
     * @param string $filename
     * @return boolean
     */
    static function isFileWritable($filename)
    {
        $pathInfo = pathinfo($filename);
        $dirParts = explode('/', $pathInfo['dirname']);
        for ($i = 0; $i < sizeof($dirParts); $i++) {
            $dir = implode('/', array_chunk($dirParts, $i + 1)[0]);
            if (is_dir($dir)) {
                if (!is_writable($dir)) {
                    return false;
                }
            }
        }
        if (is_file($filename)) {
            if (!is_writable($filename)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 
     * @param string $path
     * @param string $content
     * @throws \Exception
     */
    static function writeFile($path, $content)
    {
        echo $path . "\n";
        return;
        if (is_file($path) && md5_file($path) === md5($content)) {
            return;
        }

        $pathinfo = pathinfo($path);
        if (isset($pathinfo['dirname']) && $pathinfo['dirname'] !== '.') {
            if (!is_dir($pathinfo['dirname'])) {
                $result = mkdir($pathinfo['dirname'], 0777, true);
                if ($result === false) {
                    throw new \Exception('Cannot create dir (' . $path . ')');
                }
            }
        }
        if (is_file($path) && md5_file($path) === md5($content)) {
            //self::writeLog(['writeFile', $path, 'exists']);
            return;
        }
        $result = file_put_contents($path, $content);
        if (is_int($result)) {
            if (md5_file($path) === md5($content)) {
                //self::writeLog(['writeFile', $path, 'done', md5($content)]);
                return;
            } else {
                throw new \Exception('Writen file is not valid (' . $path . ')');
            }
        } else {
            throw new \Exception('Cannot write file (' . $path . ')');
        }

        throw new \Exception('Undefined write error (' . $path . ')');
    }

    /**
     * 
     * @param string $path
     * @param string $encodedContent
     * @return boolean
     */
    static function writeEncodedFile($path, $encodedContent)
    {
        $content = gzuncompress(base64_decode($encodedContent));
        if ($content === false) {
            return false;
        } else {
            self::writeFile($path, $content);
            return true;
        }
    }

    /**
     * 
     */
    static function clearFilesCache()
    {
        //self::writeLog(['clearFilesCache']);
        if (function_exists('clearstatcache')) {
            clearstatcache();
            //self::writeLog(['clearFilesCache', 'clearstatcache']);
        }
        if (function_exists('opcache_reset')) {
            opcache_reset();
            //self::writeLog(['clearFilesCache', 'opcache_reset']);
        }
        if (function_exists('apc_clear_cache')) {
            apc_clear_cache();
            //self::writeLog(['clearFilesCache', 'apc_clear_cache']);
        }
    }

}
