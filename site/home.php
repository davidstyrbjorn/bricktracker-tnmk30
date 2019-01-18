


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
		<title>BrickTracker - Welcome!</title>
		<meta name="description" content="Keep track of your collection online!">
  		<meta name="keywords" content="Bricks Lego collection track tracking ">
  		<meta name="author" content="Emil Bertholdsson, David Styrbjörn, Linus Karlsson, Max Benecke">
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  		<link  href="../css/style.css" rel="stylesheet"/>
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<?php
        session_start();
        include '../php/config.php';
        include '../php/script.php';
		
		resetPageNumber();
        resetMyPage();
		?>
		
    </head>
    
    <body>
    
        <nav>
            <div class="wrapper">
                <div class="nav-items">
                    <div class="nav-items-left">
					
						<!--
                        <a class="nav-item" href="home.php">BRICK_TRACKER</a>
                        <a class="nav-item-grayed" href="home.php">MY PAGE</a>
                        <a class="nav-item-grayed" href="home.php">ADD</a>
						-->
					
						<?php
						// Are we logged in?
						$logged_in = false;
						if(isset($_SESSION["logged_in"])){
							if($_SESSION["logged_in"]){
								$logged_in = true;
							}
						}
																		
						if($logged_in){
							echo "<a class='nav-item logo' href='home.php'>BRICK<span>TRACKER</span></a>";
							echo "<a class='nav-item' href='mypage.php'>MY PAGE</a>";
							echo "<a class='nav-item' href='add.php'>ADD</a>";
						}
						else{
                            
							echo "<a class='nav-item logo' href='home.php'>BRICK<span>TRACKER</span></a>";
							echo "<a class='nav-item-grayed' href='login.php'>MY PAGE</a>";
							echo "<a class='nav-item-grayed' href='login.php'>ADD</a>";
						}
						
						?>
		
                    </div>
                    <div class="nav-items-right">
					
						<?php
                        
						// Are we logged in?
						$logged_in = false;
						if(isset($_SESSION["logged_in"])){
							if($_SESSION["logged_in"]){
								$logged_in = true;
							}
						}
						
						// Sign in our out button?
						if(!$logged_in){
                            
							echo "<a class='nav-item nav-item-right' href='login.php'>LOG IN</a>";
						}
						else{
                            echo "<p class='nav-p'>Logged in as <span class='username'>";
                            echo getUserName($_SESSION['user_id']);
                            echo "</span><p>";
							echo "<a class='nav-item nav-item-right' href='../php/logout.php'>LOG OUT</a>";
						}
						?>
					
						<!--
                        <a class="nav-item nav-item-right" href="login.php">LOG IN</a>
						-->
                    </div>
                </div>
            </div>
        </nav>
        <header id="hover-header">
            <div class="header-window">
                <h1 id="header-window-text">Welcome to BrickTracker</h1>
                <h5>Keep track of your LEGO collection online with BrickTracker! Sign up today for a place to easily store each set that you've purchased.</h5>
                <a class="register-btn" href="register.php">REGISTER HERE</a>
            </div>
        </header>
        
        <div class="wrapper">
            <div class="main">
                <div class="section section-1">
                    <img src="https://i.imgur.com/shl3c81.jpg" alt="About">
                    <article>
                        <h2>About</h2>
                        <p>BrickTracker is an online tool for easy management of your own pesonal collection. With BrickTracker, you can create a personal list of purchased sets and easily keep track of what pieces you own. 
                            
                        Once you've created an account, simply search for the sets you'd like to keep track of and click to add them to your collection.</p>
                    </article>
                </div>
                <div class="section section-2">
                    
                    <article>
                        <h2>Database</h2>
                        <p>Our Database contains LEGO sets and pieces with images as well as basic descriptions. For users, this means that you can check out a set that you own, or perhaps one that you're looking to purchase.</p>
                    </article>
                    <img src="https://i.imgur.com/qyi2u41.jpg" alt="Database">
                </div>
            </div>
            
            <div class="reg">
                
            </div>
            
        </div>
    
        <!-- Echoes HTML code -->
        <?php
        displayFooter();
        ?>

    </body>
</html>