<?php

use Core\Container;
use Core\Database;

$container = new Container();

$container->bind("Core\Database", function () {
    $config = require basePath("libs/config.php");

    $host = $config["database"]["host"];
    $port = $config["database"]["port"];
    $dbname = $config["database"]["dbname"];
    $user = $config["database"]["user"];
    $password = $config["database"]["password"];

    return new Database($host, $port, $dbname, $user, $password);
});
