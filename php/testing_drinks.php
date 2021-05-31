<?php
include_once "classes.php";

echo "note that u need to have a valid bean id to insert a drink with the current db";
//reading drink with id 1 from db
 
    //read drink by id
    $drink = new Drink(null);
    if(0)
    {
        $drink->by_id(2);
        $drink->display();
    }
    //insert a new drink
    if(0)
    {
        $res = $drink->insert(array("capaccuino",100));
        if($res){echo "inserted succefully";}
        else{echo "error data didnt insert";}
    }
    //update drink
    if(0)
    {
        //enter the values in an array and the id as the second parameter
        $res = $drink->update(array("name",90), 2);
        if($res){echo "updated succefully";}
        else{echo "didnt get updated";}
    }
    //delete drink
    if(0)
    {
        //enter id you want to delete
        $res = $drink->delete(3);
        if($res){echo "deleted succefully";}
        else{echo "didnt get deleted";}
    }

    


?>