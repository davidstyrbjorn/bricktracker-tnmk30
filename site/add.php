<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
		<title>BrickTracker - Add</title>
		<meta name="description" content="Keep track of your collection online!">
  		<meta name="keywords" content="Bricks Lego collection track tracking ">
  		<meta name="author" content="Emil Bertholdsson, David Styrbjörn, Linus Karlsson, Max Benecke">
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  		<link  href="../css/style.css" rel="stylesheet"/>
  		<script src="../Js/Common.js"></script>
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<?php
		// Start session, alot of session variables in use!
		session_start();
		
		// Include all needed php files
		include "../php/config.php";
        include "../php/script.php";
        
        // If we're not logged in, redirect to login.php
        if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
            header("location:login.php");
        }
		
		// Lets do this so the mypage page is back to 1 when the player goes back
		$_SESSION["mypage_page"] = 1;
		if(!isset($_SESSION["sets_page"])){
			$_SESSION["sets_page"] = 1;
        }
		?>
		
    </head>
    
    <body>
    
        <nav>
            <div class="wrapper">
                <div class="nav-items">
                    <div class="nav-items-left">
                        <a class="nav-item logo" href="home.php">
                        
                   BRICK<span>TRACKER</span>
                        
                        </a>
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
        <header id="header-add">
            <div class="header-window">
                <h1 id="header-window-text">ADD</h1>
                <h5>Add sets to your Lego collection!</h5>
               
            </div>
        </header>
        <div class="wrapper">
            
            <form class="search" action="add.php" method="get">
                <input type="text" placeholder="Search for SetID, SetName or SetYear" value="" name="search_string">
                <button type="submit">Search</button>
            </form>
            
            <div class="lego-table-container">
  
				  
				  
				  
				  
				  <?php				  
				  // Display the search
				  if(isset($_GET["search_string"])){
						$newSearch = true;
						// New search? if so reset page number
						if(isset($_SESSION["last_search"])){
							if($_SESSION["last_search"] != $_GET["search_string"]){
								resetPageNumber();
								$newSearch = true;
							}
							else{
								$newSearch = false;
							}
						}

						// Set last search to new search string
						$_SESSION["last_search"] = $_GET["search_string"];
						
						// Do some actual displaying
						searchForSetAndDisplay(filter_input(INPUT_GET, "search_string", FILTER_SANITIZE_SPECIAL_CHARS), $newSearch);						
				  }else{
					  noSearch();
				  }
				  
				  ?>

                </div>
				
				<?php
				if(isset($_GET["search_string"]) && $_SESSION["search_count"] > 0){
					displayPaginationAddSets();
				}

				?>
			
        </div>
        
        <button class="up-button" onclick="topFunction()">Take me to the top</button>

        <!-- Echoes HTML code -->
        <?php
        displayFooter();
        ?>
        
        
        
    </body>
</html>