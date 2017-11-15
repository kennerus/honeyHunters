<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 14.11.2017
 * Time: 9:39
 */

include __DIR__ . '/init.php';
$db->insert([
    'Name' => $_POST['name'],
    'Email' => $_POST['email'],
    'Comment' => $_POST['textarea'],
], 'comments');

\libs\Parser::render(ROOT_DIR . '/views/_block.php', [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'comment' => $_POST['textarea'],
]);