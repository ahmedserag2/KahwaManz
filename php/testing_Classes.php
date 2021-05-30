<?php

include_once "classes.php";

//reading drink with id 1 from db
if(0)
{    
    $drink = new Drink();
    $drink->by_id(1);
    $drink->display();
}

    //beans testing case
    if(1)
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
        if(1)
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