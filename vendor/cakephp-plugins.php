<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CakePdf' => $baseDir . '/vendor/friendsofcake/cakepdf/',
        'Ceeram/Blame' => $baseDir . '/vendor/ceeram/cakephp-blame/',
        'CsvView' => $baseDir . '/vendor/friendsofcake/cakephp-csvview/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Josegonzalez/Upload' => $baseDir . '/vendor/josegonzalez/cakephp-upload/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Muffin/Footprint' => $baseDir . '/vendor/muffin/footprint/',
        'TinyAuth' => $baseDir . '/vendor/dereuromark/cakephp-tinyauth/'
    ]
];
