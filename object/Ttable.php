<?php


class Ttable 
{   
    private $params;//параметры таблицы;
    private $header;// таблицы;
    private $rows;//параметры таблицы;


    private $currentrow;
    private $rowcount;


    function __construct()
    {
        $this->clear();
    }

    function clear()
    {
        $this->params="";
        $this->header=[];
        $this->rows=[];
        $this->currentrow="";
        $this->rowcount=0;
    }

    function addparams($param)
    {
        $this->param.= $param;
    }

    function startrow($header=0)
    {
        if ($header){
            $this->header=array("param"=>"", "cells"=>[]);
            $this->currentrow="header";
        }
        else{
            $this->currentrow="";
            $this->rows[$this->rowcount]=array("param"=>"", "cells"=>[]);
        }
    }

    function addrowparam($params)
    {
        if ($this->currentrow == 'header')
        {
            $this->header['param'].=$params;
        }
        else{
            $this->rows[$this->rowcount]['param'].=$params;
        }
    }

    function addcell($cell)
    {
        if ($this->currentrow == 'header')
        {
            $this->header['cells'][]=$cell;
        }
        else
        {
            $this->rows[$this->rowcount]['cells'][]=$cell;
        }
    }


    function finishrow()
    {
        $this->rowcount++;
    }

    function out()
    {
        $res="<table ".$this->param.">";

        if ($this->header){
                $res.="<th ".$this->header['param'].">";
                for ($f=0; $f<count($this->header['cells']); $f++){
                    $res.="<td>".$this->header['cells'][$f]."</td>";
                }
                $res.="</th>";
        }
        else{
            for ($i=0; $i<$this->rowcount; $i++){
                $res.="<tr ".$this->rows[$this->$i]['param'].">";
                for ($f=0; $f<count($this->rows[$i]['cells']); $f++){
                    $res.="<td>".$this->rows[$i]['cells'][$f]."</td>";
                    }   
                $res.="</tr>";
                }
        }
        $res.="</table>";

        return $res;
    }
    


}