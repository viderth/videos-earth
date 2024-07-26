<?php
session_start();



include("connection.php");
include("functions.php");




?>

<!DOCTYPE html>	

<html>

   
    <head>
	
	  	<title>Welcome</title>

	    <link rel="stylesheet" href="style.css">	
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="nav.js" defer></script>
        <script src="gpscharting.js" defer></script>
	</head>
	
	<body>
    <div class="logged-top">
    
    <p class="logged-top-logo">vid<span class="red">e</span>rth</p>
<button class="mobile-nav-toggle" aria-contorls="primary-navigation" aria-expanded="false">


</button>
    
<nav>
    <ul id ="primary-navigation" data-visible="false" class="primary-navigation">
            <li><a class="primary-nav-item" href="index.php">Signout</a></li>
            <li><a class="primary-nav-item" href="profile.php">Profile</a></li>
            <li><a class="primary-nav-item" href="favorites.php">Favorites</a></li>
            <li><a class="primary-nav-item" href="feed-preferences.php">Feed Preferences</a></li>
</ul>
</nav>        

           
           
        </div>
       <div class ="drop-menus"> 
            <button class="find-drop-toggle" aria-controls="find-drop-menu" aria-expanded="false"></button>
            <p class="logged-find"><span class="red">find</span> an adventure</p>
            <button class="share-drop-toggle" aria-controls="share-drop-menu" aria-expanded="false"></button>
                <p class="logged-share"><span class="red">share</span> an adventure</p>


        </div>

        <nav>
            <ul id ="find-drop-menu" data-visible="false" class="find-drop-menu">
                <li>Tag Search</li><br>
                <li>Keyword Search</li><br>
                <li>Current Conditions</li><br>
            </ul>
        </nav>



        <nav>
            <ul id ="share-drop-menu" data-visible="false" class="share-drop-menu">
                <li>Full Adventure</li><br>
                <li>Current Conditions</li><br>
                <li>Stories</li><br>
            </ul>
        </nav>

                <p class="post-scroll-title">Mt. Galbraith</p></a>
					    <div class="user-id-block">
							<img class="profile-pic" src="images/profilepic.jpg">				
							
							<div class ="user-id">
								<p class="post-author">MountainMan01</p>
								<p class="activity-count">125 adventures</p>
                            </div>	
                        </div>

                            <div class="post-content-column">
                                <iframe  class="post-video" src="https://www.youtube.com/embed/7wlTG3RSPJc" title="Mt Galbraith" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe><br>
				            
                                <iframe  class="post-map"src="https://www.google.com/maps/d/u/0/embed?mid=1eBYJyzzK0QmCDoFh0PQp6gYFv_M&ehbc=2E312F" frameborder="0"></iframe>
                                </div>
                
	  		        

                    <p class ="adventure-description">Mt. Galbraith is located just outside of Denver just as you enter the front range.  There is parking and restroom facilities. 
                        It is a fairly popular location and parking fills up fast.  Get there early to avoid needing to park down the road.  
                        You basically traverse out the first half going up in elevation and then the second half is all downhill.</p>








<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <canvas id="gpxChart"></canvas>
    <script src="chart.js"></script>
</body>

