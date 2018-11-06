<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

require __DIR__ . '/vendor/autoload.php';

$docsGenerator = new IvoPetkov\DocsGenerator(__DIR__, ['/src']);
$docsGenerator->generateMarkdown(__DIR__ . '/docs/markdown');
