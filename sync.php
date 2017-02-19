<?php
/**
 * Code launched to sync data from Twitch using kraken api
 */

//Set timezone
date_default_timezone_set('Europe/Helsinki');
$date = date('Y-m-d h:i:s');

$db = new Core_Database();

/**
 * @param $channelName
 * @return array
 */
function getStatusTwitch($channelName)
{
    $config = new Core_Config();
    $configValues = $config->getConfig();

    $clientId = $configValues['twitch_key'];

    $apiUrl = "https://api.twitch.tv/kraken/streams/";
    $json_array = json_decode(file_get_contents($apiUrl.strtolower($channelName).'?client_id='.$clientId), true);

    if ($json_array['stream'] != NULL) {
        return $data = array(
            'status'=>'1',
            'display_name'=>$channelName,
            'stream_title'=>$json_array['stream']['channel']['status'],
            'game'=>$json_array['stream']['channel']['game'],
            'viewers'=>$json_array['stream']['viewers'],
            'logo'=>$json_array['stream']['channel']['logo']
        );
    } else {
        return $data = array(
            'status'=>'0',
            'display_name'=>$channelName,
            'stream_title'=>null,
            'game'=>null,
            'viewers'=>null,
            'logo'=>$json_array['stream']['channel']['logo']
        );
    }
}

/**
 * @param $db
 */
function syncStreamerStatus($db) {

    foreach (array_unique($db->getNames()) as $name)
    {
        echo "Checking " . $name . PHP_EOL;
        $tmp = $db->dataByName($name);
        $data = getStatusTwitch($name);
        if ($tmp['game'] != $data['game'] || $tmp['status'] != $data['status'] || isset($tmp['title']) && $tmp['title'] != $data['stream_title'])
        {
            echo "Updating " . $name . PHP_EOL;
            $db->updateStatus(
                $name,
                $data['status'],
                $data['game'],
                $data['stream_title'],
                $data['logo'],
                $data['viewers']
            );
        }
    }
}
syncStreamerStatus($db);
