<?php

include_once("object/Tform.php");
include_once("object/Ttable.php");
include_once("object/view.php");
include_once("model/Musers.php");


$userobj = new Musers;
$content = $userobj->execute(); //Получаем данные 
$obj = new Cview("template/page.html");
$obj -> make(array("content" =>$content));// Отправляем данные в html