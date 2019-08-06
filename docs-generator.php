<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

require __DIR__ . '/vendor/autoload.php';

$docsGenerator = new IvoPetkov\DocsGenerator(__DIR__);
$docsGenerator->addSourceDir('/src');
$docsGenerator->addExamplesDir('/examples');
$options = [
    'showProtected' => false,
    'showPrivate' => false
];
$docsGenerator->generateMarkdown(__DIR__ . '/docs/markdown', $options);
//$docsGenerator->generateHTML(__DIR__ . '/docs/html', $options);
//$docsGenerator->generateJSON(__DIR__ . '/docs/json');
