<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 14.11.2017
 * Time: 9:12
 */
define('ROOT_DIR', __DIR__);

require_once ROOT_DIR . '/libs/Debug.php';
require_once ROOT_DIR . '/config/Config.php';
require_once ROOT_DIR . '/libs/Parser.php';
require_once ROOT_DIR . '/libs/Db.php';

$db = new \libs\Db();