<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
		<title>BrickTracker - Welcome!</title>
		<meta name="description" content="Keep track of your collection online!">
  		<meta name="keywords" content="Bricks Lego collection track tracking ">
  		<meta name="author" content="Emil Bertholdsson, David Styrbjörn, Linus Karlsson, Max Benecke">
        <link href="https://fonts.googleapis.com/css?family=Quicksand|Varela+Round|Roboto|Montserrat" rel="stylesheet">
  		<link  href="../css/style.css" rel="stylesheet"/>
  		<script src=""></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
          
        <?php
		session_start();
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
							echo "<a class='nav-item' href='home.php'>BRICK_TRACKER</a>";
							echo "<a class='nav-item' href='mypage.php'>MY PAGE</a>";
							echo "<a class='nav-item' href='add.php'>ADD</a>";
						}
						else{
                            
							echo "<a class='nav-item' href='home.php'>BRICK_TRACKER</a>";
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
                
        <div class="wrapper-terms">
            <div class="main">
                <div class="section section-1">
                    <article>
        <h2>Terms & Privacy</h2>


        <p>Effective date: January 10, 2019</p>


        <p>BrickTracker ("us", "we", or "our") operates the BrickTracker website (herein refered to as the "Service").</p>
            
        <p>This page informs you of the service terms, regarding site usage and disclosure of personal data. By signing up for and using this service, you approve of and agree to the terms persented on this page.</p>
                        
        <h2>Terms of Service</h2>
        <ul>
        <li>You acknowledge and consent to the possibility of having your regiestered personal information saved in our database.</li>
        <li>You acknowledge the fact that the service is in no way, shape or form affiliated with The Lego Group.</li>
        <li>You acknowledge the fact that the service is made as a first year university project, and that certain aspects of the service may suffer from flaws.</li>
        </ul>
                        
        <h2>Information Collection And Use</h2>
        
        <p>When registering for our service, we will ask to collect certain personal data for various purposes, in order to provide and improve our service.</p>
        
        <p>Collected data includes, but is not limited to:</p>
        <ul>
            <li>Registration E-Mail Adress</li>
        </ul>          
                        
        <p>Please note that no electronic system is 100% secure, and that though we care about privacy, we cannot guarantee absolute security regarding storage of entered information.</p>
        
        <h2>Contact Us</h2>
        
        <p>If you have any questions regarding the service or the terms & privacy conditions, please <a href = "mailto:brick_tracker_team@gmail.com">contact us by email.</a></p>
                    </article>
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