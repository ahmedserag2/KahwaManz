<?php

include_once "classes.php";

//reading drink with id 1 from db
if(0)
{   
    //read drink by id
    $drink = new Drink();
    if(0)
    {
        $drink->by_id(1);
        $drink->display();
    }
    //insert a new drink
    if(0)
    {
        $res = $drink->insert(array("capaccuino",1,4,"rise and grind",100));
        if($res){echo "inserted succefully";}
        else{echo "error data didnt insert";}
    }
    //update drink
    if(0)
    {
        $res = $drink->update(array("name",1,5,1,90),3);
        if($res){echo "updated succefully";}
        else{echo "didnt get updated";}
    }
    //delete drink
    if(0)
    {
        $res = $drink->delete(3);
        if($res){echo "deleted succefully";}
        else{echo "didnt get deleted";}
    }

    
}


//condiment testing
if(1)
{
    $condiment = new Condiment();
    //insert
    if(0)
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
    
}


//beans testing cases
if(0)
{
    $bean = new Beans();
    //inserting into beans table 
    if(0)
    {     
        $res = $bean->insert(array("test2",100));
        if($res)
        {
            echo "inserted into db";
        }
        else
        {
            echo "failed to insert";
        }
    }

    //testing the update beans table currently active
    if(0)
    {
        //pass in the values getting updated as array and the id
        $res = $bean->update(array("updatetest",30), 6);
        if($res)
        {
            echo "record updated succesfuly";
        }
        else
        {
            echo "record failed to update";
        }
    }

    //testing delete
    if(0)
    {
        $res = $bean->delete(6);
        if($res)
        {
            echo "record deleted succefly";
        }
        else
        {
            echo "error in sql record wasnt deleted";
        }
    }
    

}

?>