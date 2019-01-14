<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
		<title>BrickTracker - Mypage</title>
		<meta name="description" content="Keep track of your collection online!">
  		<meta name="keywords" content="Bricks Lego collection track tracking ">
  		<meta name="author" content="Emil Bertholdsson, David Styrbjörn, Linus Karlsson, Max Benecke">
        <link href="https://fonts.googleapis.com/css?family=Quicksand|Varela+Round|Roboto|Montserrat" rel="stylesheet">
  		<link  href="../css/style.css" rel="stylesheet"/>
  		<script src="../Js/Common.js"></script>
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!--
		PHP Include
		-->
		<?php
		session_start();
		include "../php/config.php";
		include "../php/script.php";

        // If we're not logged in, redirect to login.php
        if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
            header("location:login.php");
        }

        resetPageNumber();
		?>
		
    </head>
    
    <body>
    
        <nav>
            <div class="wrapper">
                <div class="nav-items">
                    <div class="nav-items-left">
                        <a class="nav-item" href="home.php">BRICK_TRACKER</a>
                        <a class="nav-item" href="mypage.php">MY PAGE</a>
                        <a class="nav-item" href="add.php">ADD</a>
                    </div>
                    <div class="nav-items-right">
					
						<p class='nav-p'>Logged in as <span class='username'>
						<?php
						echo getUserName($_SESSION['user_id']);
						?>
						</span><p>
                        <a class="nav-item nav-item-right" href="../php/logout.php">LOG OUT</a>
                    </div>
                </div>
            </div>
        </nav>
        <header>
       
            <div class="header-window-mypage header-window">
                <br>
                <br>
				<?php
				displayUserInfo();
				?>
                
            </div>
        </header>
        <div class="wrapper">
            <div class="lego-table-container">


				  <?php
		
				  if(getUserSetCount() > 0){
						echo "<table class='lego-table'>";
						echo "<tr>";
						
						echo "<th>ID</th>";
						echo "<th>NAME</th>";
						echo "<th>YEAR</th>";
						echo "<th>IMAGE</th>";
						echo "<th>REMOVE</th>";
						echo "</tr>";
						
						displayOwnedSets();
						echo "</table>";
				  }
				  else{
					  emptyMyPage();
				  }
				  ?>
				  
				  </div>

        <?php
		if(getUserSetCount() > 0){
			displayPaginationMypage();
		}
		?>
        
        </div>
        
        <button class="up-button" onclick="topFunction()">Ta mig till toppen</button>
        <!-- Echoes HTML code -->
        <?php
        displayFooter();
        ?>

    </body>
</html>