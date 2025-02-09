<?php

$config = require basePath("libs/config.php");

use ImageKit\ImageKit;

$imagekit = new Imagekit(
    $config["imagekit"]["publicKey"],
    $config["imagekit"]["privateKey"],
    $config["imagekit"]["urlEndPoint"]
);