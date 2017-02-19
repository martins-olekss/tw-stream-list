# tw-stream-list
Personal Twitch streamer list using kraken API

**Requirements:**
- php
- mysql
- ability to run php in cli (updating data from twitch.tv)
- twitch.tv API ID

**Preparation:**
- Create new database
- Enter configuration parameters into `Core/config.ini` file (can omit twitch key for starters)
- Run `php cli.php install` to create new table within previously defined database

**Usage:**
- Run php `cli.php add <username>` to add twitch streamer to your streamer list
- Retrieve Twitch API id from twitch.tv and enter it in `Core/config.ini` file (if not done previously)
- Run `php cli.php sync` to retrieve data from twitch.tv for your streamers
- Execute `php cli.php help` for all available commands

**Intended everyday usage:**
- Set cron / scheduler to execute `php cli.php sync` every few minutes
- See streamer list using browser
