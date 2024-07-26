<?php
session_start();

include("connection.php");
include("functions.php");

?>

<!DOCTYPE html>	

<html>

   
    <head>
	
	  	<title>Mt. Falcon</title>

        <link rel="stylesheet" href="style.css">	
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="nav.js" defer></script>
		<script src="parseGPX.js"></script>
		<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
 		<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
       

                <p class="post-scroll-title">Mt. Falcon<//p></a>
					    <div class="user-id-block">
							<img class="profile-pic" src="images/profilepic.jpg">				
							
							<div class="user-id">
								<p class="post-author">MountainMan01</p>
								<p class="activity-count">125 adventures</p>
                            </div>	
                        </div>

                            <div class="post-content-column">
                                <iframe  class="post-video" src="https://www.youtube.com/embed/7wlTG3RSPJc" title="Mt Galbraith" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe><br>
				            
                                <div class="map-google" id='map' frameborder="0"></div>

                                <p class ="adventure-description">Mt. Galbraith is located just outside of Denver just as you enter the front range.  There is parking and restroom facilities. 
                                    It is a fairly popular location and parking fills up fast.  Get there early to avoid needing to park down the road.  
                                    You basically traverse out the first half going up in elevation and then the second half is all downhill.</p>

                                    
                        

                            <canvas class="post-chart" id="gpsChart"></canvas>
                            <script src="jscharttest.js"></script>

                                </div>
<script>

    // Initialize the map
    var map = L.map('map', {
	zoomControl: false
   }).setView([39.715413, -105.309065], 8,);
	// Set the initial center coordinates and zoom level
  
    // Add a base layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// Load the GPX file
fetch('http://localhost/mtfalcon2.gpx')
  .then(response => response.text())
  .then(gpxData => {
    // Parse the GPX data and extract coordinates using the parseGPX function
    var traceCoordinates = parsemGPX(gpxData);

    // Create a polyline from the trace coordinates and add it to the map
    var polyline = L.polyline(traceCoordinates, { color: 'green' }).addTo(map);

   // Get the bounds of the polyline
var polylineBounds = polyline.getBounds();

// Extend the bounds by a certain amount in all directions
var padding = 0; // Adjust this value as needed

// Calculate the new bounds with padding
var southWest = L.latLng(polylineBounds.getSouth(), polylineBounds.getWest());
var northEast = L.latLng(polylineBounds.getNorth(), polylineBounds.getEast());
var extendedBounds = L.latLngBounds(southWest, northEast).pad(padding);

// Fit the map to the extended bounds
map.fitBounds(extendedBounds);
  })
  .catch(error => console.error('Error loading GPX file:', error));

  </script>