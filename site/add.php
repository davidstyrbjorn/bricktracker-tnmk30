<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
		<title>BrickTracker - Add</title>
		<meta name="description" content="Keep track of your collection online!">
  		<meta name="keywords" content="Bricks Lego collection track tracking ">
  		<meta name="author" content="Emil Bertholdsson, David Styrbjörn, Linus Karlsson, Max Benecke">
        <link href="https://fonts.googleapis.com/css?family=Quicksand|Varela+Round|Roboto|Montserrat" rel="stylesheet">
  		<link  href="../css/style.css" rel="stylesheet"/>
  		<script src=""></script>
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<?php
		// Start session, alot of session variables in use!
		session_start();
		
		// Include all needed php files
		include "../php/config.php";
		include "../php/script.php";
		
		// Lets do this so the mypage page is back to 1 when the player goes back
		$_SESSION["mypage_page"] = 1;
		?>
		
    </head>
    
    <body>
    
        <nav>
            <div class="wrapper">
                <div class="nav-items">
                    <div class="nav-items-left">
                        <a class="nav-item" href="home.php">BRICK_TRACKER</a>
                        <a class="nav-item" href="mypage.php">SETS</a>
                        <a class="nav-item" href="add.php">ADD</a>
                    </div>
                    <div class="nav-items-right">
                        <a class="nav-item nav-item-right" href="">LOG IN</a>
                    </div>
                </div>
            </div>
        </nav>
        <header id="hover-header">
            <div class="header-window">
                <h1 id="header-window-text">ADD</h1>
                <h5>Add sets to your Lego collection!</h5>
               
            </div>
        </header>
        <div class="wrapper">
            
            <form class="search" action="add.php" method="get">
                <input type="text" placeholder="Search for SetID, SetName, SetYear..." value="" name="search_string">
                <button type="submit">Search</button>
            </form>
            
                <table class="lego-table">
                  <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>YEAR</th>
                    <th>IMAGE</th>
                    <th>ADD</th>
                  </tr>
				  
				  <?php
				  if(isset($_GET["search_string"])){
						// New search? if so reset page number
						if(isset($_SESSION["last_search"])){
							if($_SESSION["last_search"] != $_GET["search_string"]){
								resetPageNumber();
							}
						}

						// Set last search to new search string
						$_SESSION["last_search"] = $_GET["search_string"];
						
						// Do some actual displaying
						searchForSetAndDisplay($_SESSION["last_search"]);
				  }
				  ?>
				 
                </table>
				
				<?php
				if(isset($_GET["search_string"])){
					displayPaginationAddSets();
				}
				?>
			
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