<?php
session_start();

include("connection.php");
include("functions.php");

?>


<html>

   
    <head>
	
	  	<title>Welcome</title>

	    <link rel="stylesheet" href="style.css">	
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="nav.js" defer></script>
		<script src="parseGPX.js"></script>
		<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
 		<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

		

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
      
<div class="post-scroll">
			<div class="video-map-column">			
				<iframe class="video-youtube" src="https://www.youtube.com/embed/7wlTG3RSPJc" title="Mt Galbraith" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
					<div class="map-google" id='map' frameborder="0"></div>	 
				
				</div>
			
			 


			<div class="info-column">
				<div class="title-user-block">
				<a href="mtfalcon.php"><p class="post-scroll-title">Mt. Falcon</p></a>
					<div class="user-id-block">
							<img class="profile-pic" src="images/profilepic.jpg">				
							
							<div class ="user-id">
								<p class="post-author">MountainMan01</p>
								<p class="activity-count">125 adventures</p>
							</div>
					</div>
				</div>
					<div class="scroll-info-block">
						<div class ="scroll-info">
							<p class="post-length">length: 4.2 miles</p>
							<p class="post-difficulty">difficulty: easy</p>
						</div>
					 		<img class="directions-icon" src="images/img_321696.png">
					</div>
						<div class="tag-block">
							<button class="hike-tag">hike</button>
							<button class="hike-tag">Golden CO</button>
							<button class="hike-tag">Jeffco Open Space</button>
						</div>
				</div>
			</div>
		</div>
		</div>

		<div class="post-scroll">
			<div class="video-map-column">			
				<iframe class="video-youtube" src="https://www.youtube.com/embed/x7ubRIj1-c0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
					<div class="map-google" id='map2' frameborder="0"></div>
	  		</div>
			
			<div class="info-column">
				<div class="title-user-block">
					<p class="post-scroll-title">Windy Saddle Park</p></a>
					<div class="user-id-block">
							<img class="profile-pic" src="images/profilepic.jpg">				
							
							<div class ="user-id">
								<p class="post-author">MountainMan01</p>
								<p class="activity-count">125 adventures</p>
							</div>
					</div>
				</div>
					<div class="scroll-info-block">
						<div class ="scroll-info">
							<p class="post-length">length: 9 miles</p>
							<p class="post-difficulty">difficulty: moderate</p>
						</div>
					 		<img class="directions-icon" src="images/img_321696.png">
					</div>
						<div class="tag-block">
							<button class="hike-tag">bike</button>
							<button class="hike-tag">random text</button>
							<button class="hike-tag">hike</button>
							<button class="hike-tag">hike</button>
							<button class="hike-tag">hikasdfe</button>
							<button class="hike-tag">hike</button>
						</div>
				</div>
			</div>
		</div>
		</div>


    </body>
	
	
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
fetch('http://localhost/mtfalcon.gpx')
  .then(response => response.text())
  .then(gpxData => {
    // Parse the GPX data and extract coordinates using the parseGPX function
    var traceCoordinates = parseGPX(gpxData);

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

   // Initialize the map
   var map2 = L.map('map2', {
	zoomControl: false
   }).setView([39.715413, -105.309065], 8); // Set the initial center coordinates and zoom level
  // Add a base layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map2);

// Load the GPX file
fetch('http://localhost/windysaddle.gpx')
.then(response => response.text())
.then(gpxData => {
  // Parse the GPX data and extract coordinates using the parseGPX function
  var traceCoordinates = parseGPX(gpxData);

  // Create a polyline from the trace coordinates and add it to the map
  var polyline = L.polyline(traceCoordinates, { color: 'green' }).addTo(map2);

 // Get the bounds of the polyline
var polylineBounds = polyline.getBounds();

// Extend the bounds by a certain amount in all directions
var padding = 0; // Adjust this value as needed

// Calculate the new bounds with padding
var southWest = L.latLng(polylineBounds.getSouth(), polylineBounds.getWest());
var northEast = L.latLng(polylineBounds.getNorth(), polylineBounds.getEast());
var extendedBounds = L.latLngBounds(southWest, northEast).pad(padding);

// Fit the map to the extended bounds
map2.fitBounds(extendedBounds);
})
.catch(error => console.error('Error loading GPX file:', error));




</script>


