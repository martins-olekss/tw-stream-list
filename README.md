# tw-stream-list
Twitch streamer list

Requirements:
- php
- mysql

Preparation / usage:
- Create new database
- Enter configuration parameters into Core/config.ini file (can omit twitch key for starters)
- Run php cli.php install to create new table within previously defined database
- Run php cli.php add <username> to add twitch streamer to your streamer list
- Retrieve Twitch id from twitch.tv and enter it in Core/config.ini file (if not done previously)
- Run php cli.php sync to retrieve data from twitch.tv for your streamers
