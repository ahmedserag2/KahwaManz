
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
            <form method = "get" >
                
                <input type = "text" id = "search" name = "search" rq>
                <input type = "submit" class = "btn btn-warning" value = "search">
            </form>
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
                        <th scope="col">User Name</th>
                        <th scope="col">email</th>
                        <th scope="col">mobile</th>

                        <th scope="col">Role</th>
                        <th scope="col">Action</th>


                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $class = new User(0);
                        
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
                    <a class="page-link" href="<?php echo "admin_users.php?p=".($currentPage-1) ?>" aria-label="Previous"> 
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span> <?php }?>
                </a>
                </li>
                <?php for($i = 0; $i < $noOfPages; $i++){
                    $pNum = $i + 1;
                    echo "<li class='page-item'><a class='page-link' href='admin_users.php?p={$i}'>{$pNum}</a></li>";


                }?>
                
                <?php if($currentPage < $noOfPages -1){ ?>
                <li class="page-item">
                <a class="page-link" href="<?php echo "admin_users.php?p=".($currentPage+1) ?>" aria-label="Next">
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






<!--add user Modal -->
    <div class="modal modal-addItem fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9e7540;">

                    <h5 class="modal-title" id="addItemModalLabel">Add a drink</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body my-custom-scrollbar">
                <form method = "get" action="">

                   <div class = "form-group row">

                        <label for = "nameAdd"  class = "col-sm-3">user Name</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "nameAdd" id = "nameAdd" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "emailAdd"  class = "col-sm-3">Email</label>
                        <div class = "col-sm-6">
                            <input type = "email" name = "emailAdd" id = "emailAdd" required>
                        </div>
                   </div>

                   

                   <div class = "form-group row">

                        <label for = "passwordAdd"  class = "col-sm-3">password</label>
                        <div class = "col-sm-6">
                            <input type = "password" name = "passwordAdd" id = "passwordAdd" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "mobileAdd"  class = "col-sm-3">mobile</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "mobileAdd" id = "mobileAdd" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "type"  class = "col-sm-3">type</label>
                        <div class = "col-sm-6">
                            <select name = "typeAdd" id="typeAdd">
                                <option value="" disabled selected>Choose option</option>
                                <option value="admin">Admin</option>
                                <option value="employee">Employee</option>
                             
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

                    <h5 class="modal-title" id="editItemModalLabel">Edit a drink</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body my-custom-scrollbar">
                <form method = "get" action="">

                   <div class = "form-group row">
                        <input type = "hidden" name = "idEdit" id = "idEdit" required>
                        
                   </div>

                   <div class = "form-group row">

                        <label for = "nameEdit"  class = "col-sm-3">user Name</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "nameEdit" id = "nameEdit" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "emailEdit"  class = "col-sm-3">Email</label>
                        <div class = "col-sm-6">
                            <input type = "email" name = "emailEdit" id = "emailEdit" required>
                        </div>
                   </div>

                   

                   <div class = "form-group row">

                        <label for = "passwordAdd"  class = "col-sm-3">password</label>
                        <div class = "col-sm-6">
                            <input type = "password" name = "passwordEdit" id = "passwordEdit" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "mobileAdd"  class = "col-sm-3">mobile</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "mobileEdit" id = "mobileEdit" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "type"  class = "col-sm-3">type</label>
                        <div class = "col-sm-6">
                            <select name = "typeEdit" id="typeEdit">
                                <option value="" disabled selected>Choose option</option>
                                <option value="admin">Admin</option>
                                <option value="employee">Employee</option>
                             
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
        document.getElementById("nameEdit").value = data.username;
        document.getElementById("emailEdit").value = data.email;
        document.getElementById("mobileEdit").value = data.mobile;
        document.getElementById("passwordEdit").value = data.password;
        document.getElementById("typeEdit").value = data.type;


    }

   

</script>


<?php 

//submiting values from modal into db 
    //thats if wer adding a new drink to db 
    
    if(isset($_GET['nameAdd']))
    {
        
        $username = $_GET['nameAdd'];
        $email = $_GET['emailAdd'];
        $mobile = $_GET['mobileAdd'];
        $password = $_GET['passwordAdd'];
        $type = $_GET['typeAdd'];

        $user = new User(null);
        //need to change to option select
        $user->insert(array($username,$email,$password, $mobile,$type));

        echo '<script>window.location.replace("admin_users.php");</script>';
    }
    // when editing a drink
    if(isset($_GET['nameEdit']))
    {
        $id = $_GET['idEdit'];
        $username = $_GET['nameEdit'];
        $email = $_GET['emailEdit'];
        $mobile = $_GET['mobileEdit'];
        $password = $_GET['passwordEdit'];
        $type = $_GET['typeEdit'];

        $user = new User(null);

        //put the feilds in the same order as in the db 
        $user->update(array($username,$email,$password, $mobile,$type), $id);
        echo '<script>window.location.replace("admin_users.php");</script>';

    }

    //checking for delete request
    if(isset($_GET['delete']))
    {
        $id = $_GET['delete'];
        $user = new User(null);
        $user->delete($id);
        echo '<script>window.location.replace("admin_users.php");</script>';
    }


?>