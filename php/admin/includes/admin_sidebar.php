<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="./includes/CSS/admin_sidebar.css">
</head>
  
	

		<nav class="side-bar">
			<div class="user-p">
			<?php
				include_once "../classes.php"; //access the drinks page
				session_start();

				
			
			?>
				<h4><?php echo $_SESSION['user']->get_name(); ?></h4>
			</div>
			<ul>
				
				<li>
					<a href="admin_drinks.php">
						<i class="fa fa-shopping-basket" aria-hidden="true"></i>
						<span>Drinks</span>
					</a>
				</li>
        		<li>
					<a href="admin_users.php">
						<i class="fa fa-users" aria-hidden="true"></i>
						<span>Users</span>
					</a>
				</li>

				<li>
					<a href="admin_beverages.php">
						<i class="fa fa-glass"></i>
						<span>beverages</span>
					</a>
				</li>

				<li>
					<a href="admin_condiments.php">
						<i class="fa fa-plus" aria-hidden="true"></i>
						<span>condiments</span>
					</a>
				</li>

				<li>
					<a href="admin_orders.php">
						<i class="fa fa-first-order" aria-hidden="true"></i>
						<span>Orders</span>
					</a>
				</li>
				
				
				
				<li>
					<a href="admin_logout.php">
						<i class="fa fa-power-off" aria-hidden="true"></i>
						<span>Logout</span>
					</a>
				</li>
			</ul>
		</nav>
		

    

    

  

</html>