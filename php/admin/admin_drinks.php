
<body>
    <?php include_once "./includes/admin_header.php";?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <div class= "body">

        <?php include_once "./includes/admin_sidebar.php";?>
        
        <?php include_once "../classes.php"; //access the drinks page?>

        

        <section class="section-1">
            <img src="../../images/cappucino.jpg" style="width:100%;height:30%" alt="Italian Trulli">
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
                        <th scope="col">Description</th>

                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $class = new Drink(0);
                        $class = $class->select_all();
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






<!--add drink Modal -->
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

                        <label for = "name"  class = "col-sm-3">Drink's Name</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "name" id = "name" required>
                        </div>
                   </div>

                   <div class = "form-group row">

                        <label for = "price"  class = "col-sm-3">Price</label>
                        <div class = "col-sm-6">
                            <input type = "text" name = "price" id = "price" required>
                        </div>
                   </div>

                   <p><b>Description</b></p>
                    <div class="form-group">
                    <div class="col-sm-12">
                        <textarea id="editor1" name="description" rows="10" cols="50" required></textarea>
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