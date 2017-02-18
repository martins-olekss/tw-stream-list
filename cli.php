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
        echo "View streamer list withing terminal using {view}" . PHP_EOL;
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

    if ($cmd && $cmd == "view" && empty($username)) {
        echo "STREAMER LIST:" . PHP_EOL;

        error_reporting(E_ALL);

        $db = new Core_Database();
        $streamer_data = $db->getStreamerData();

        foreach($streamer_data as $item){
            $status = ($item['status'] != "0") ? "online" : "offline";
            echo "### STREAMER: \t".$item['twitch_name']." ###" . PHP_EOL;
            echo "STATUS: \t" . $status . PHP_EOL;
            echo "LINK: \t\thttps://www.twitch.tv/".$item['twitch_name'] . PHP_EOL;
            if ($status == "online") {
                echo "PLAYING: \t" . $item['game'] . PHP_EOL;
                echo "TITLE: \t\t" . $item['title'] . PHP_EOL;
                echo "VIEWERS: \t" . $item['viewers'] . PHP_EOL;
            }
            echo PHP_EOL;
        }
    }

    if ($cmd && $cmd == "install" && empty($username)) {
        //Create tables
        $db = new Core_Database();
        $db->install();
    }
}