<?php

namespace App;

class View
{
    protected array $data = [];

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function display(string $template)
    {
        ob_start();
        include $template . '.php';
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    public function render(string $template, array $data = [])
    {
        ob_start();

        foreach ($data as $articles) {
            $keyArray = [];
            foreach ($articles as $key => $value) {
                $keyArray['{' . strtoupper($key) . '}'] = $value;
            }
            $subject = file_get_contents($template . '.php');

            $search = array_keys((array)$keyArray);
            $replace = array_values((array)$articles);
//            echo '<BR>SEARCH === <pre>';
//            var_dump($search);
//            echo '<BR>REPLACE === <pre>';
//            var_dump($replace);
//            echo '<BR>SUBJECT === ';
            //var_dump($subject);
            //echo str_replace($search, $replace, $subject);
            echo str_replace($search, $replace, $subject);
        }
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    public function render_v2(string $template, array $data): false|string
    {
        $search = [];
        $replace = [];

        ob_start();
        foreach ($data as $key => $value) {
            $search[] = '{' . strtoupper($key) . '}';
            $replace[] = $value;
        }

        $subject = file_get_contents($template . '.php');
        echo str_replace($search, $replace, $subject);

        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }


    public function render_v3(string $template, array $data = [], array $access = []): false|string
    {
        $subject = file_get_contents($template . '.php');

        foreach ($access as $key => $value) {
            if ($value == 1 ) {
                $subject = preg_replace( '/\[' . $key . '](.+?)\[\/' . $key . ']/s', '$1', $subject );
            } else {
                $subject = preg_replace( '/\[' . $key . '](.+?)\[\/' . $key . ']/s', '', $subject );
            }
        }

        $search = [];
        $replace = [];
        foreach ($data as $key => $value) {
            $search[] = '{' . strtoupper($key) . '}';
            $replace[] = $value;
        }

        ob_start();
        echo str_replace($search, $replace, $subject);
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
}
