<?php

include __DIR__ . '/init.php';

$blocks = $db->find('comments')->all();

\libs\Parser::render(ROOT_DIR . '/views/admin.php', ['blocks' => $blocks]);