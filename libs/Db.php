<?php
namespace libs;

use config\Config;

/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 25.05.2016
 * Time: 11:52
 */
class Db
{
    public $stat;
    private $settings;
    private $connect;
    private $defaults;
    public $query;
    public $table;
    public $count = 0;

    public function __construct(array $data = array())
    {
        $config = new Config();
        $this->defaults = $config->db();
        $this->settings = array_merge($this->defaults, $data);
        $this->connect = mysqli_connect($this->settings['localhost'], $this->settings['user'], $this->settings['pass'], $this->settings['db']);

        if (!$this->connect) {
            printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }

        mysqli_set_charset($this->connect, $this->settings['charset']);
    }

    /**
     * @param string $query
     * @return array|bool
     */
    public function rawQuery($query)
    {
        $start = microtime(TRUE);
        $result = mysqli_query($this->connect, $query);
        $timer = microtime(TRUE) - $start;
        $this->count++;
        $this->stat[] = array(
            'query' => $query,
            'start' => $start,
            'timer' => $timer,
            'count' => $this->count
        );
        if ($result) {
            if (is_object($result)) {
                $arr = $this->getArray($result);
                $this->free($result);
            } else {
                $arr = true;
            }
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * @param string $query
     * @return array|bool
     */
    public function getAll($query)
    {
        return $this->rawQuery($query);
    }

    /**
     * @param string $query
     * @return bool
     */
    public function getOne($query)
    {
        $res = $this->rawQuery($query);
        if (!empty($res)) {
            return $res[0];
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @param string $table
     * @return bool
     */

    public function getFromId($id, $table)
    {
        $query = "SELECT * FROM `$table` WHERE id = $id";
        return $this->getOne($query);
    }

    /**
     * @param string $field
     * @param string|integer $value
     * @param string $table
     * @param bool $direct
     * @return array|bool
     */
    public function getByField($field, $value, $table, $direct = false)
    {
        $query = "SELECT * FROM `$table` WHERE ";
        if (is_int($value)) {
            $query .= "$field = $value";
        } else {
            if ($direct) {
                $query .= " $field LIKE '$value'";
            } else {
                $query .= " $field LIKE '%$value%'";
            }
        }
        return $this->rawQuery($query);
    }

    /**
     * Проверяет существуют ли данные в таблице
     * @param array $data
     * @param string $table
     * @return bool|int|string
     */
    public function insert($data, $table)
    {
        if (!empty($data)) {
            $query = "INSERT INTO `$table` ";
            $key = "(";
            $value = "(";
            foreach ($data as $k => $v) {
                $key .= $k . ",";
                if (is_int($v)) {
                    $value .= $v . ",";
                } else {
                    $value .= "'" . $v . "',";
                }
            }
            $key = substr($key, 0, -1);
            $value = substr($value, 0, -1);
            $key .= ")";
            $value .= ")";
            $query .= $key . 'VALUES' . $value;
            if ($this->rawQuery($query)) {
                return mysqli_insert_id($this->connect);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $data array данные которые необходимо обновить
     * @param $table string
     * @param $where array
     * @param $direct bool
     * @return array|bool
     */
    public function update($data, $table, $where, $direct = false)
    {
        if (!empty($data)) {
            $query = "UPDATE `$table` SET";
            foreach ($data as $k => $v) {
                if (is_int($v)) {
                    $query .= " $k = $v,";
                } else {
                    $query .= " $k = '$v',";
                }
            }
            $query = substr($query, 0, -1);
            $query .= ' WHERE';
            foreach ($where as $k => $v) {
                if ($k == 'id') {
                    $query .= " $k = $v";
                } else {
                    if (is_int($v)) {
                        $query .= " $k = $v";
                    } else {
                        if ($direct) {
                            $query .= " $k LIKE '$v'";
                        } else {
                            $query .= " $k LIKE '% $v %'";
                        }
                    }
                }
                $query .= ' AND';
            }
            $query = substr($query, 0, -3);
            //prn($query);
            return $this->rawQuery($query);
        }
    }

    /**
     * @param object $result
     */
    public function free($result)
    {
        mysqli_free_result($result);
    }


    public function getRow()
    {
    }

    /**
     * @param object $res
     * @return array
     */
    private function getArray($res)
    {
        $arr = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $arr[] = $row;
        }
        return $arr;
    }

    /**
     * @param string $table
     * @param int $id
     * @return array|bool
     */
    public function queryDelete($table, $id)
    {
        $query = "DELETE FROM `$table` WHERE id=$id";
        return $this->rawQuery($query);
    }

    /**
     * @param string $table
     * @param string $field
     * @param int|string $value
     * @return array|bool
     */
    public function queryDeleteByField($table, $field, $value)
    {
        $query = "DELETE FROM `$table` WHERE `$field` = '$value'";
        return $this->rawQuery($query);;
    }

    /**
     * @param array $where
     * @param string $table
     * @param bool $direct
     * @return mixed
     */
    public function _isset($where, $table, $direct = false)
    {
        $query = "SELECT COUNT(*) as count FROM `$table` ";
        $query .= " WHERE";
        foreach ($where as $k => $v) {
            if ($k == 'id') {
                $query .= " $k = $v";
            } else {
                if (is_int($v)) {
                    $query .= " $k = $v";
                } else {
                    if ($direct) {
                        $query .= " $k LIKE '$v'";
                    } else {
                        $query .= " $k LIKE '%$v%'";
                    }
                }
            }
            $query .= ' AND';
        }
        //var_dump($query);
        $query = substr($query, 0, -3);
        //prn($query);
        $isset = $this->rawQuery($query);
        return $isset[0]['count'];
    }


    /**
     * @param array $data
     * @param string $table
     * @param bool $direct
     * @return array|bool
     * Поиск по БД
     */
    public function getWhere($data, $table, $direct = false)
    {
        $query = "SELECT * FROM `$table` ";
        $query .= ' WHERE';
        foreach ($data as $k => $v) {
            if ($k == 'id') {
                $query .= " $k = $v";
            } else {
                if (is_int($v)) {
                    $query .= " $k = $v";
                } else {
                    if ($direct) {
                        $query .= " $k LIKE '$v'";
                    } else {
                        $query .= " $k LIKE '%$v%'";
                    }
                }
            }
            $query .= ' AND';
        }
        //var_dump($query);
        $query = substr($query, 0, -3);
        $res = $this->rawQuery($query);
        //prn($res);
        return $res;
    }

    /**
     * @param string $table
     * @param $select
     * @return $this
     */
    public function find($table, $select = '*')
    {
        $this->table = $table;
        $this->query = 'SELECT ' . $select . " FROM $table";
        return $this;
    }

    /**
     * @param array $data
     * @param string $logics
     * @param bool $direct
     * @return $this
     */
    public function where($data, $logics = 'AND', $direct = false)
    {
        $this->query .= ' WHERE';
        foreach ($data as $k => $v) {
            if ($k == 'id') {
                $this->query .= " $k = $v";
            } else {
                if (is_int($v) or is_numeric($v)) {
                    $this->query .= " $k = $v";
                } else {
                    if ($direct) {
                        $this->query .= " $k LIKE '$v'";
                    } else {
                        $this->query .= " $k LIKE '%$v%'";
                    }
                }
            }
            $this->query .= ' ' . $logics;

        }
        //var_dump($query);
        $this->query = substr($this->query, 0, -3);
        return $this;
    }

    /**
     * @param array $data
     * @param string $logics
     * @param bool $direct
     * @return $this
     */
    public function andWhere($data, $logics = 'AND', $direct = false)
    {
        $this->query .= ' AND (';
        foreach ($data as $k => $v) {
            if ($k == 'id') {
                $this->query .= " $k = $v";
            } else {
                if (is_int($v)) {
                    $this->query .= " $k = $v";
                } else {
                    if ($direct) {
                        $this->query .= " $k LIKE '$v'";
                    } else {
                        $this->query .= " $k LIKE '%$v%'";
                    }
                }
            }
            $this->query .= ' ' . $logics;

        }
        //var_dump($query);
        $this->query = substr($this->query, 0, -3);
        $this->query .= ')';
        return $this;
    }

    /**
     * @param array $data
     * @param string $logics
     * @param bool $direct
     * @return $this
     */
    public function orWhere($data, $logics = 'OR', $direct = false)
    {
        $this->query .= " OR (" ;
        foreach ($data as $k => $v) {
            if ($k == 'id') {
                $this->query .= " $k = $v";
            } else {
                if (is_int($v)) {
                    $this->query .= " $k = $v";
                } else {
                    if ($direct) {
                        $this->query .= " $k LIKE '$v'";
                    } else {
                        $this->query .= " $k LIKE '%$v%'";
                    }
                }
            }
            $this->query .= " " . $logics;

        }
        //var_dump($query);
        $this->query = substr($this->query, 0, -3);
        $this->query .= ')';
        return $this;
    }

    /**
     * @param int $count
     * @param bool $offset
     * @return $this
     */
    public function limit($count, $offset = false)
    {
        if ($offset) {
            $this->query .= "LIMIT $offset , $count ";
        } else {
            $this->query .= "LIMIT $count ";
        }
        return $this;
    }

    /**
     * @param string $order
     * @return $this
     */
    public function orderBy($order)
    {
        $this->query .= ' ORDER BY ' . $order . ' ';
        return $this;
    }

    /**
     * @param string $group
     * @return $this
     */
    public function groupBy($group)
    {
        $this->query .= ' GROUP BY ' . $group . ' ';
        return $this;
    }

    /**
     * @param string $table
     * @param string $param
     * @param string $join
     * @return $this
     */
    public function join($table, $param, $join = "")
    {
        $this->query .= $join . " JOIN  $table ON  $param";
        return $this;
    }

    /**
     * @param string $table
     * @param string $param
     * @param string $join
     * @return $this
     */
    public function leftJoin($table, $param, $join = "")
    {
        $this->query .= $join . " LEFT JOIN  $table ON  $param";
        return $this;
    }

    /**
     * @return array|bool
     */
    public function all()
    {
        return $this->rawQuery($this->query);
    }

    /**
     * @return bool
     */
    public function one()
    {
        return $this->getOne($this->query);
    }

    public function insertMany($data, $table)
    {

        if (!empty($data)) {
            $query = "INSERT INTO `$table` ";
            $key = '(';
            foreach ($data[0] as $k => $value) {
                $key .= $k . ', ';

            }
            $key = substr($key, 0, -2);

            $key .= ')';
            $query .= $key . ' VALUES ';
            foreach($data as $value){
                $query .= ' (';
                foreach($value as $item){
                    if (is_int($item)) {
                        $query .= $item . ",";
                    } else {
                        $query .= "'" . $item . "',";
                    }
                }
                $query = substr($query, 0, -1);
                $query .= '),';
            }
            $query = substr($query, 0, -1);
            return $this->rawQuery($query);

        } else {
            return false;
        }
    }
}