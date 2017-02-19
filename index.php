<?php
error_reporting(E_ALL);

require('Core/Autoload.php');
spl_autoload_register('autoload');

$config = new Core_Config();
$configValues = $config->getConfig();

$db = new Core_Database();
$streamer_data = $db->getStreamerData();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Twitch Streamers</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8">
</head>

<body>
    <div class="wrapper">
        <?php foreach($streamer_data as $item): ?>
            <div class="stream-item <?php echo ($item['status'] != "0") ? "online" : "" ?>">
                <div class="streamer">
                    <div class="logo">
                        <a href="<?php echo "https://www.twitch.tv/".$item['twitch_name'] ?>">
                            <img src="<?php echo (!is_null($item['logo'])) ? $item['logo'] : "img/blank.png" ?>" />
                        </a>
                    </div>
                    <div class="link">
                        <div class="link">
                            <a href="<?php echo "https://www.twitch.tv/".$item['twitch_name'] ?>">
                                <?php echo $item['twitch_name'] ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="game"><span><?php echo $item['game'] ?></span></div>
                <div class="title"><?php echo $item['title'] ?></div>
                <div class="view"><?php echo $item['viewers'] ?></div>
            </div>
        <?php endforeach; ?>
    <div class="footer">
        <span>mail [at] gmail.com</span>
    </div>
</body>
</html>
