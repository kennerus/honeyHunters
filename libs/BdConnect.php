<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 12.10.2017
 * Time: 18:20
 */

namespace libs;

use config\Config;

class BdConnect
{

	public function __construct($data) {
		$config = new Config();
		$this->defaults = $config->db();
		$this->settings = array_merge($this->defaults, $data);
		$this->connect = mysqli_connect($this->settings['localhost'], $this->settings['root'], $this->settings['1'], $this->settings['db']);

		if (!$this->connect) {
			printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
			exit;
		} 
		else {
			mysqli_set_charset($this->connect, "utf8");
		}
		return $this->connect;
	}

    public function getConnect()
    {
        return $this->mysql();
    }

}