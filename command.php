<?php
declare(strict_types=1);

// TODO: CommandNamespace?
if (! class_exists('WP_CLI')) {
    return;
}

// TODO: WP_CLI::add_command( 'hello-world', $hello_world_command );.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
