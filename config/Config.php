<?php

/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 25.05.2016
 * Time: 12:04
 */

namespace config;

class Config
{

    public function db()
    {
        return [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'db' => 'cms',
            'port' => NULL,
            'socket' => NULL,
            'pconnect' => FALSE,
            'charset' => 'utf8',
            'suffix' => 'k_',
        ];
    }

    public function routing()
    {
        return [
            'admin-panel' => 'k-admin',
        ];
    }

    public function user()
    {
        return [
            'rule' => 'user'
        ];
    }

}