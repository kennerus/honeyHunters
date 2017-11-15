<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 15.11.2017
 * Time: 17:58
 */

include __DIR__ . '/init.php';

$db->queryDeleteByField('comments', 'ID', $_POST['itemId']);