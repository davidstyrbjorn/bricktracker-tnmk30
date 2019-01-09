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
    </head>
    
    <body>
    
        <nav>
            <div class="wrapper">
                <div class="nav-items">
                    <div class="nav-items-left">
                        <a class="nav-item" href="home.php">BRICK_TRACKER</a>
                        <a class="nav-item-grayed" href="#">MY PAGE</a>
                        <a class="nav-item-grayed" href="#">ADD</a>
                    </div>
                    <div class="nav-items-right">
                        <a class="nav-item nav-item-right" href="">LOG IN</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="outer-login">
            <h2 class="login-title">BrickTracker Login</h2>
            <div class="login-window">
			
				<?php
				if(isset($_GET["fail_message"])){
					if($_GET["fail_message"] == "user_not_found"){
						echo "<p class='fail_message'>Wrong username or password!</p>";
					}
					else{
						echo "<p class='fail_message'>Wrong username or password!</p>";
					}
				}
				?>
				
                <form action="../php/login_validate.php" method="post">
                    <h5 class="label">Username or Email</h5>
                    <input type="text" name="identification">
                    <h5 class="label">Password</h5>
                    <input type="password" name="password">
                    <button type="submit" class="submit-btn login-btn">Log in</button>
                </form>
                <p>Not a member? Register <a href="register.php">here!</a></p>
            </div>
        </div>

        
        <footer>
            <div class="wrapper">
                <div class="footer-sections">
                    <div class="footer-section">
                        <ul>
                            <li class="list-header">Help</li>
                            <li><a>Bla</a></li>
                            <li><a>Bla</a></li>
                            <li><a>Bla</a></li>
                            <li><a>Bla</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <ul>
                            <li class="list-header">Help</li>
                            <li><a>Bla</a></li>
                            <li><a>Bla</a></li>
                            <li><a>Bla</a></li>
                            <li><a>Bla</a></li>
                        </ul>
                    </div>
                </div>
            
            
            
            </div>
            
            
        </footer>
        
        
        
    </body>
</html>