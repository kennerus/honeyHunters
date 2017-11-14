<?php

namespace libs;

class Parser {

    /**
     * @param string $tpl
     * @param array $data
     * @param bool $view
     * @return mixed|string
     */
    public static function parse ($tpl, $data = array(), $view = false) {
        $file = file_get_contents($tpl); // Получаем шаблон

        foreach ($data as $key => $value) {
            $key = "{".$key."}";
            $file = preg_replace("/$key/", $value, $file);
        }

        if ($view == true) {
            echo $file;
        }
        elseif($view == false) {
            return $file;
        }
    }

    /**
     * @param string $tpl
     * @param array $data
     * @param bool $view
     * @return string
     */
    public static function render($tpl, $data = array(), $view = true){
        if(!empty($data)){
            foreach($data as $k => $v){
                ${$k} = $v;
            }
        }
        if($view){
            include($tpl);
        }
        else {
            ob_start();
            include($tpl);
            $a = ob_get_contents();
            ob_end_clean();
            return $a;
        }
    }

} 