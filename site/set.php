<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
		<title>BrickTracker - Set</title>
		<meta name="description" content="Keep track of your collection online!">
  		<meta name="keywords" content="Bricks Lego collection track tracking ">
  		<meta name="author" content="Emil Bertholdsson, David Styrbjörn, Linus Karlsson, Max Benecke">
        <link href="https://fonts.googleapis.com/css?family=Quicksand|Varela+Round|Roboto|Montserrat" rel="stylesheet">
  		<link  href="../css/style.css" rel="stylesheet"/>
  		<script src=""></script>
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

        // Reset bricks page?
        if(isset($_SESSION["last_set_id"])){
            if($_SESSION["last_set_id"] != $_GET["set_id"]){
                resetBricksPage();
            }
        }

        if(isset($_GET["set_id"])){
            $_SESSION["last_set_id"] = $_GET["set_id"];
        }
        
        resetMyPage();
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
            
            <div class="header-window">
                <br>
                <br>
                <br>
                <div class="h-window-flex">
				    <?php
				    displaySetInfo($_GET["set_id"]);
				    ?>
				</div>
            </div>
        </header>
        <div class="wrapper">
            
                <table class="lego-table">
					<tr>
						<th>ID</th>
						<th>NAME</th>
						<th>QUANTITY</th>
						<th>IMAGE</th>
					</tr>
					
					<?php
					displaySetPieces($_GET["set_id"]); 
					?>

                </table>

        
        
        </div>
		
		<?php
		displayPagenationBricks($_GET["set_id"]);
        ?>
		
		<a href="bottomOfPage"></a>
		
         <footer>
            
            <div class="wrapper">
                <div class="footer-sections">
                    <div class="footer-section">
                        <ul>
                            <li class="list-header">BrickTracker</li>
                            <li><a>©2019 BrickTracker</a></li>
                            <li><a>David Styrbjörn, Emil Bertholdsson, Linus Karlsson, Max Benecke</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <ul>
                            <li class="list-header">Help</li>
                            <li><a class="footer-link">Terms & Privacy</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <ul>
                            <li class="list-header">Contact</li>
                            <li><a>For any site or account related questions, please </a><a class="footer-link" href = "mailto: brick_tracker_team@gmail.com">contact us.</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </footer>
    </body>
</html>