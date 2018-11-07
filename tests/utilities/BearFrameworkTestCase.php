<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * 
 */
class BearFrameworkTestCase extends PHPUnit\Framework\TestCase
{

    private $app = null;

    /**
     *
     * @var array 
     */
    private $lockedFiles = [];

    /**
     * 
     * @param array $config
     * @return \BearFramework\App
     */
    public function getApp(array $config = []): \BearFramework\App
    {
        if ($this->app === null) {
            $this->app = $this->makeApp($config);
        }
        return $this->app;
    }

    /**
     * 
     * @param array $config
     * @return \BearFramework\App
     */
    public function makeApp(array $config = []): \BearFramework\App
    {
        $rootDir = $this->getTempDir();
        $app = new BearFramework\App();

        $appDir = $rootDir . 'app';
        $dataDir = $rootDir . 'data';
        $logsDir = $rootDir . 'logs';
        $addonsDir = $rootDir . 'addons';

        mkdir($appDir, 0777, true);
        mkdir($dataDir, 0777, true);
        mkdir($logsDir, 0777, true);
        mkdir($addonsDir, 0777, true);

        $appDir = str_replace('\\', '/', realpath($appDir));
        $dataDir = str_replace('\\', '/', realpath($dataDir));
        $logsDir = str_replace('\\', '/', realpath($logsDir));
        $addonsDir = str_replace('\\', '/', realpath($addonsDir));

        $initialConfig = [
            'appDir' => $appDir,
            'dataDir' => $dataDir,
            'logsDir' => $logsDir,
            'addonsDir' => $addonsDir
        ];
        $config = array_merge($initialConfig, $config);
        foreach ($config as $key => $value) {
            $app->config->$key = $value;
        }
        $app->request->base = 'http://example.com/www';
        $app->request->method = 'GET';

        $app->data->useFileDriver($dataDir);
        $app->cache->useAppDataDriver();
        $app->logs->useFileLogger($logsDir);

        $appIndexContent = isset($config['appIndexContent']) ? (string) $config['appIndexContent'] : '<?php ';
        if (strlen($appIndexContent) > 0) {
            file_put_contents($appDir . '/index.php', $appIndexContent);
            $app->contexts->add($appDir);
        }

        return $app;
    }

    /**
     * 
     * @return string
     */
    public function getTempDir(): string
    {
        $dir = sys_get_temp_dir() . '/bearframework-unittests/' . uniqid();
        $this->makeDir($dir);
        return $dir;
    }

    /**
     * 
     * @param string $dir
     * @return void
     */
    public function makeDir(string $dir): void
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    /**
     * 
     * @param string $filename
     * @param string $content
     * @return void
     */
    public function makeFile(string $filename, string $content): void
    {
        if (strpos($filename, '://') === false) {
            $pathinfo = pathinfo($filename);
            if (isset($pathinfo['dirname']) && $pathinfo['dirname'] !== '.') {
                $this->makeDir($pathinfo['dirname']);
            }
        }
        file_put_contents($filename, $content);
    }

    /**
     * 
     * @param string $filename
     * @param string $type
     * @return void
     * @throws \Exception
     */
    public function makeSampleFile(string $filename, string $type): void
    {
        if ($type === 'png') {
            $this->makeFile($filename, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAGQAAABGCAIAAAC15KY+AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4AIECCIIiEjqvwAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAAd0lEQVR42u3QMQEAAAgDILV/51nBzwci0CmuRoEsWbJkyZKlQJYsWbJkyVIgS5YsWbJkKZAlS5YsWbIUyJIlS5YsWQpkyZIlS5YsBbJkyZIlS5YCWbJkyZIlS4EsWbJkyZKlQJYsWbJkyVIgS5YsWbJkKZAl69sC1G0Bi52qvwoAAAAASUVORK5CYII='));
        } elseif ($type === 'jpg' || $type === 'jpeg') {
            $this->makeFile($filename, base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wCEAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAf/CABEIAEYAZAMBEQACEQEDEQH/xAAVAAEBAAAAAAAAAAAAAAAAAAAACf/aAAgBAQAAAACL4AAAAAAAAAAAAAAAAAAB/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAn/2gAIAQIQAAAAlOAAAAAAAAAAAAAAAAAAAf/EABUBAQEAAAAAAAAAAAAAAAAAAAAK/9oACAEDEAAAAL+AAAAAAAAAAAAAAAAAAAD/xAAUEAEAAAAAAAAAAAAAAAAAAABg/9oACAEBAAE/AGv/xAAUEQEAAAAAAAAAAAAAAAAAAABg/9oACAECAQE/AGv/xAAUEQEAAAAAAAAAAAAAAAAAAABg/9oACAEDAQE/AGv/2Q=='));
        } elseif ($type === 'gif') {
            $this->makeFile($filename, base64_decode('R0lGODdhZABGAPAAAP8AAAAAACwAAAAAZABGAAACXISPqcvtD6OctNqLs968+w+G4kiW5omm6sq27gvH8kzX9o3n+s73/g8MCofEovGITCqXzKbzCY1Kp9Sq9YrNarfcrvcLDovH5LL5jE6r1+y2+w2Py+f0uv2Oz5cLADs='));
        } elseif ($type === 'webp') {
            $this->makeFile($filename, base64_decode('UklGRlYAAABXRUJQVlA4IEoAAADQAwCdASpkAEYAAAAAJaQB2APwA/QACFiY02iY02iY02iY02iYywAA/v9vVv//8sPx/Unn/yxD///4npzeIqeV//EyAAAAAAAAAA=='));
        } elseif ($type === 'bmp') {
            $this->makeFile($filename, base64_decode('Qk16AAAAAAAAAHYAAAAoAAAAAQAAAAEAAAABAAQAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAgAAAAICAAIAAAACAAIAAgIAAAICAgADAwMAAAAD/AAD/AAAA//8A/wAAAP8A/wD//wAA////APAAAAA='));
        } elseif ($type === 'broken') {
            $this->makeFile($filename, base64_decode('broken'));
        } else {
            throw new \Exception('Unsupported file type (' . $type . ')!');
        }
    }

    /**
     * 
     * @param string $filename
     * @return void
     */
    public function lockFile(string $filename): void
    {
        $pathinfo = pathinfo($filename);
        if (isset($pathinfo['dirname']) && $pathinfo['dirname'] !== '.') {
            $this->makeDir($pathinfo['dirname']);
        }
        $index = sizeof($this->lockedFiles);
        $this->lockedFiles[$index] = fopen($filename, "c+");
        flock($this->lockedFiles[$index], LOCK_EX | LOCK_NB);
    }

}
