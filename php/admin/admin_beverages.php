
<body>
    <?php include_once "./includes/admin_header.php";?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <div class= "body">

        <?php include_once "./includes/admin_sidebar.php";?>
        
        <?php include_once "../classes.php"; //access the drinks page?>

        

        <section class="section-1">
            <img src="../../images/cappucino.jpg" style="width:100%;height:30%" alt="Italian Trulli">
            <div class = "row" style = "margin:15px;">
            
            </div>
            <div class = "row">
                <div class = "col">
                    
                    <button  type="button" class="btn btn-warning add" data-toggle="modal" data-target="#addItemModal">ADD</button>
                </div>
            </div>
            <div class = "table-responsive">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Drink's Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Type</th>

                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $class = new Beverage(0);
                        
                        $noOfItems = count($class->select_all());
                        $itemsPerPage = 3;
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
        
        <?php if(!isset($_GET['search']) || $_GET['search'] == ""){ ?>
        <div style="margin:10px;">
        <h5>Pages</h5>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                <?php if($currentPage > 0){ ?>
                    <a class="page-link" href="<?php echo "admin_beverages.php?p=".($currentPage-1) ?>" aria-label="Previous"> 
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span> <?php }?>
                </a>
                </li>
                <?php for($i = 0; $i < $noOfPages; $i++){
                    $pNum = $i + 1;
                    echo "<li class='page-item'><a class='page-link' href='admin_beverages.php?p={$i}'>{$pNum}</a></li>";


                }?>
                
                <?php if($currentPage < $noOfPages -1){ ?>
                <li class="page-item">
                <a class="page-link" href="<?php echo "admin_beverages.php?p=".($currentPage+1) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                <?php } ?>
                </li>
            </ul>
        </nav>
        </div>
        <?php }?>
        </section>

    
    </div>

    


</body>






<!--add drink Modal -->
    <div class="modal modal-addItem fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9e7540;">

                    <h5 class="modal-title" id="addItemModalLabel">Add a Beverage</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body my-custom-scrollbar">
                <form method = "get" action="">

                   <div class = "form-group row">

                        <label for = "nameAdd"  class = "col-sm-3">beverage's Name</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "nameAdd" id = "nameAdd" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "price"  class = "col-sm-3">Price</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "priceAdd" id = "priceAdd" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "type"  class = "col-sm-3">type</label>
                        <div class = "col-sm-6">
                            <select name = "typeAdd" id="typeAdd">
                                <option value="" disabled selected>Choose option</option>
                                <option value="sauce">suace</option>
                                <option value="sweetner">sweetner</option>
                                <option value="creamer">creamer</option>
                                <option value="milk">milk</option>
                            </select>
                        </div>
                   </div>

                   

                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning submit" >Add</button>
                        <button type="button" class="btn btn-warning closeModal" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>



            </div>
        </div>

    </div>
<!-- modal ended -->



<!--Edit drink Modal -->
    <div class="modal modal-editItem fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9e7540;">

                    <h5 class="modal-title" id="editItemModalLabel">Edit Beverage</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body my-custom-scrollbar">
                <form method = "get" action="">

                   <div class = "form-group row">
                        <input type = "hidden" name = "idEdit" id = "idEdit" required>
                        <label for = "nameEdit"  class = "col-sm-3">Beverage's Name</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "nameEdit" id = "nameEdit" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "price"  class = "col-sm-3">Price</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "priceEdit" id = "priceEdit" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "type"  class = "col-sm-3">type</label>
                        <div class = "col-sm-6">
                            <select name = "typeEdit" id="typeEdit">
                                <option value="" disabled selected>Choose option</option>
                                <option value="sauce">sauce</option>
                                <option value="sweetner">sweetner</option>
                                <option value="creamer">creamer</option>
                                <option value="milk">milk</option>
                            </select>
                        </div>
                   </div>

                   

                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning submit" >Submit Edit</button>
                        <button type="button" class="btn btn-warning closeModal" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>



            </div>
        </div>

    </div>
<!-- modal ended -->



<script>

    function setEditModal(data){
        document.getElementById("idEdit").value = data.ID;
        document.getElementById("nameEdit").value = data.name;
        document.getElementById("priceEdit").value = data.price;
        document.getElementById("typeEdit").value = data.type;


    }

   

</script>


<?php 

//submiting values from modal into db 
    //thats if wer adding a new drink to db 
    
    if(isset($_GET['nameAdd']))
    {
        
        $name = $_GET['nameAdd'];
        $price = $_GET['priceAdd'];
        $type = $_GET['typeAdd'];

        $drink = new Beverage(null);
        $drink->insert(array($name,$price,$type));

        echo '<script>window.location.replace("admin_beverages.php");</script>';
    }
    // when editing a drink
    if(isset($_GET['nameEdit']))
    {
        $id = $_GET['idEdit'];
        $name = $_GET['nameEdit'];
        $price = $_GET['priceEdit'];
        $type = $_GET['typeEdit'];
        $drink = new Beverage(null);
        //put the feilds in the same order as in the db 
        $drink->update(array($name,$price,$type), $id);
        echo '<script>window.location.replace("admin_beverages.php");</script>';

    }

    //checking for delete request
    if(isset($_GET['delete']))
    {
        $id = $_GET['delete'];
        $drink = new Beverage(null);
        $drink->delete($id);
        echo '<script>window.location.replace("admin_beverages.php");</script>';
    }


?>