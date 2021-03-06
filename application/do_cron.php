<?php /*
	Copyright 2014-2015 Cédric Levieux, Jérémy Collot, ArmagNet

	This file is part of OpenTweetBar.

    OpenTweetBar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    OpenTweetBar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with OpenTweetBar.  If not, see <http://www.gnu.org/licenses/>.
*/
/*
 * Don't forget to include a cron line in the crontab like this one :

* * * * * cd /my/installed/opentweetbar/path/ && php do_cron.php

 */
include_once("config/database.php");
require_once("engine/bo/MediaBo.php");
require_once("engine/bo/TweetBo.php");

$connection = openConnection();

$tweetBo = TweetBo::newInstance($connection);
$now = date("Y-m-d H:i:s");

$tweets = $tweetBo->getCronedTweets($now);

foreach($tweets as $tweet) {
	echo "Tweet : " . $tweet["twe_id"] . "\n";

	$tweetBo->sendTweet($tweet);
	$tweetBo->updateStatus($tweet, "validated");
	echo "=> sent \n";
}

exit("done\n");
?>