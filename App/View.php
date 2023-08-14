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
        include $template;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    public function render(string $template, array $data = [])
    {
        ob_start();

        foreach ($data as $articles) {
            $keyArray = [];
            foreach($articles as $key => $value){
                $keyArray[ '{' . strtoupper($key) . '}' ] = $value;
            }
            $subject = file_get_contents($template);


//            echo '<br><br><br><br><br><br>';
//            preg_match_all('/{[A-Z]+}/', $subject, $lol);
//            var_dump($lol);
            //exit();


            $search  = array_keys((array)$keyArray);
            $replace = array_values((array)$articles);
            echo  str_replace( $search, $replace, $subject );
        }
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

}
