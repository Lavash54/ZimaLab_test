<?php


class Tform
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
        $this->cont ="";
    }

    function radio($name, $value="", $placeholder="", $header=""){
            $this->cont .=
            '<div class "col-sm-6">
                <lable for='.$name.' class="form-label">'.$header.'</label>
                <input type="radio" name='.$name.' id='.$name.' value='.$value.' />
                </div>';
      
    }

    function checkbox($name, $value="", $placeholder="", $header=""){
        $this->cont .=
        '<div class "col-sm-6">
            <lable for='.$name.' class="form-label">'.$header.'</label>
            <input type="checkbox" name='.$name.' id='.$name.' value='.$value.' />
            </div>';
  
}


    function addparams($param)
    {
        $this->param.= $param;
    }
    function addtextfield($name, $value ="", $placeholder="", $header="", $required){
        if($required == 1){
            $this->cont .=
            '<div class="col-sm-6">
              <label for="'.$name.'" class="form-label">'.$header.'</label>
              <input type="text"  class="form-control" id="'.$name.'" name = "'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'" required>
            </div>
        
        ';
    } else{
        $this->cont .=
        '<div class="col-sm-6">
          <label for="'.$name.'" class="form-label">'.$header.'</label>
          <input type="text"  class="form-control" id="'.$name.'" name = "'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'">
        </div>
    
    ';
    }
    

    }

    function addSelectField($name, $value =[], $placeholder="", $header="")
    {
        $opts="";
        foreach ($value as $key => $items){
            $sel="";
            // print_r($items);
            if ($items[2]){
                $sel= "selected";
            }
            $opts.=" <option values=\"".$items[0]."\" ".$sel.">".$items[1]."</option>";
        }

        $this->cont .=
        '<div class="col-sm-12">
              <label for="'.$name.'" class="form-label">'.$name.'</label>
              <select type="text"  class="form-control" id="'.$name.'" name = "'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'" required>'.$opts.'</select>
            </div>
        
        ';
    }



    function addpasswfield($name, $value ="", $placeholder=""){
        $this->cont .=
        '<div class="col-sm-6">
              <label for="'.$name.'" class="form-label">Password</label>
              <input type="password" class="form-control" id="'.$name.'" name = "'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'" required>
            </div>
        ';
    }

    function addsubmitfield($name, $value ="", $placeholder=""){
        $this->cont .=
        '<div class="col-sm-6">
        <input type="submit" class="form-control" id="'.$name.'" name = "'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'" required>
        </div>
        ';
    }

    function out()
    {
        $res="<form ".$this->param.">";
        $res.=$this->cont;
        $res.="</form>";

        return $res;
    }
    


}