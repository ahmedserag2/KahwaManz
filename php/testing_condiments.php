<?php

include_once "classes.php";

echo "to test deletion or updating change it from the .php file";

//condiment testing

    $condiment = new Condiment();
    $condiment->by_id(1);
    $condiment->display();
    //insert
    if(1)
    {
        $res = $condiment->insert(array("condname",40,'sauce'));
        if($res){echo "inserted succefly";}
        else{echo "failed inserting";}
    }
    //update
    if(0)
    {
        $res = $condiment->update(array("testupdatecond",40,'sauce'),2);
        if($res){echo "updated succefully";}
        else{echo "failed updating";}
    }

    //delete
    if(0)
    {
        $res = $condiment->delete(2);
        if($res){echo "deleted succefully";}
        else{echo "failed deleting";}
    }
    



?>