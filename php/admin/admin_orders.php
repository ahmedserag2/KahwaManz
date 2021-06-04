
<body>
    <?php include_once "./includes/admin_header.php";
    
        $pics_path = "../../Images/Drinks/";
    ?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <div class= "body">

        <?php include_once "./includes/admin_sidebar.php";?>
        
        <?php// include_once "../classes.php"; //access the drinks page?>

        

        <section class="section-1">
            <img src="../../images/cappucino.jpg" style="width:100%;height:30%" alt="Italian Trulli">
            <div class = "row" style = "margin:15px;">
            
            </div>
            
            <div class = "table-responsive">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">item Names</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        
                        

                        

                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $class = new Order(0);
                        
                        $noOfItems = count($class->select_all());
                        $itemsPerPage = 10;
                        $currentPage = 0;
                        if(isset($_GET['p']))
                            $currentPage = $_GET['p'];
                        $noOfPages = ceil($noOfItems / $itemsPerPage);

                       
                        if(isset($_GET['search']))
                        {
                            $class = $class->select_all($_GET['search']);    
                        }
                        else
                        {
                            //assuming wer at page 0 and want to read 4 items select_pagiated(0, 4);    
                            $class = $class->select_pagiated($currentPage, $itemsPerPage);    
                        }
                        
                        foreach ($class as $value) {
                            //var_dump($value);
                           $value->display_table_row();
                        }
                    ?>
                    
                    
                </tbody>
                </table>
            </div>
        
        
        </section>

    
    </div>

    


</body>


