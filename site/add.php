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
		session_start();
		include "../php/config.php";
		include "../php/script.php";
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
                <h5>Keep track of your LEGO collection online with BrickTracker! Sign up today for a place to easily store each set that you've purchased.</h5>
               
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
					  searchForSetAndDisplay($_GET["search_string"]);
				  }
				  ?>
				 
                </table>
				
            <table class="pagination">
                <tr>
                    <td><a href=""><<</a></td>
                    <td><a href=""><</a></td>
                    <td class="active-pagination"><a href="">1</a></td>
                    <td><a href="">2</a></td>
                    <td><a href="">3</a></td>
                    <td><a href="">></a></td>
                    <td><a href="">>></a></td>
                </tr>
            </table>
        
        
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