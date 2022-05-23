<?php

class Cview {
    private $filename;
    function __construct($filename)
    {
        $this->filename =$filename;
    }

    function make($values)
    {
        $tmpl= file_get_contents($this->filename);
        foreach ($values as $key => $values) {
            $tmpl=str_replace("{[$key]}", $values, $tmpl);
        }
        print ($tmpl);
    }

}