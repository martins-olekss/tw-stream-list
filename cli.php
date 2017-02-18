<?php
/**
 * Code used to access cli commands
 */

error_reporting(E_ALL);

require('Core/Autoload.php');
spl_autoload_register('autoload');

if (isset($argv[0]) && $argv[0] === "cli.php" && !empty($argv[1])) {
    $cmd = (isset($argv[1])) ? $argv[1] : false;
    $username = (isset($argv[2])) ? $argv[2] : false;

    if ($cmd && $cmd == "help" && empty($username)) {
        echo PHP_EOL;
        echo "Commands:" . PHP_EOL;
        echo "Create empty streamer data table if not already exists using {install}" . PHP_EOL;
        echo "Add new streamer with {add} <username>" . PHP_EOL;
        echo "To update streamer list use {sync}" . PHP_EOL;
        echo PHP_EOL;
    }

    if ($cmd && $cmd == "add" && !empty($username)) {
        $db = new Core_Database();
        $db->addStreamer($username);
        echo "Adding new streamer " . $username . PHP_EOL;
    }

    if ($cmd && $cmd == "sync" && empty($username)) {
        echo "Sync streamers" . PHP_EOL;
        include_once 'sync.php';
    }

    if ($cmd && $cmd == "install" && empty($username)) {
        //Create tables
        $db = new Core_Database();
        $db->install();
    }
}