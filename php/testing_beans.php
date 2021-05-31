<?php

include_once "classes.php";

echo "to test deletion or updating change it from the .php file";



//beans testing cases

    $bean = new Beans();
    //inserting into beans table 
    if(0)
    {     
        $res = $bean->insert(array("himalaya bean",100));
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
        $res = $bean->delete(2);
        if($res)
        {
            echo "record deleted succefly";
        }
        else
        {
            echo "error in sql record wasnt deleted";
        }
    }
    



?>