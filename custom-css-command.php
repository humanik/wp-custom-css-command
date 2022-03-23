<?php

use Humanik\WP_CLI\CustomCssCommand;

if (!class_exists('WP_CLI')) {
    return;
}

$wpcli_entity_autoloader = __DIR__ . '/vendor/autoload.php';
if (file_exists($wpcli_entity_autoloader)) {
    require_once $wpcli_entity_autoloader;
}

WP_CLI::add_command('custom-css', CustomCssCommand::class);
