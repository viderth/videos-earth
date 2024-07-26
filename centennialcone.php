<?php
session_start();

include("connection.php");
include("functions.php");

?>

<!DOCTYPE html>	

<html>

   
    <head>
	
	  	<title>Centennial Cone</title>

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
       

                <p class="post-scroll-title">Centennial Cone Park<//p></a>
					    <div class="user-id-block">
							<img class="profile-pic" src="images/profilepic.jpg">				
							
							<div class="user-id">
								<p class="post-author">MountainMan01</p>
								<p class="activity-count">125 adventures</p>
                            </div>	
                        </div>

                            <div class="post-content-column">
                               
                                <p class ="adventure-description">Mt. Galbraith is located just outside of Denver just as you enter the front range.  There is parking and restroom facilities. 
                                    It is a fairly popular location and parking fills up fast.  Get there early to avoid needing to park down the road.  
                                    You basically traverse out the first half going up in elevation and then the second half is all downhill.</p>
                                   
                                    <div class="post-data-chart">

                                    <div>Starting Elevation:</div>
                                    <div>Maximum Elevation:</div>
                                    <div>Lowest Elevation:</div>
                                    <div>Total Distance:</div>
                                    <div>Total Time:</div>
                                    <p><span id="starting-elevation">Loading...</span></p>
                                    <p><span id="max-elevation">Loading...</span></p>
                                    <p><span id="lowest-elevation">Loading...</span></p>
                                    <p><span id="total-distance">Loading...</span></p>
                                    <p><span id="total-time">Loading...</span></p>
                                    
                            </div>
                                    <iframe  class="post-video" src="https://www.youtube.com/embed/x7ubRIj1-c0" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe><br>
				            

                                <div class="map-google" id='map' frameborder="0"></div>


                                <canvas class="post-chart"  id="gpsChart"></canvas>
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
fetch('http://localhost/centennialcone.gpx')
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



    
    <script>
        const gpxUrl = 'http://localhost/centennialcone.gpx';  // Update this with the actual path to your GPX file

        function fetchGPX() {
            fetch(gpxUrl)
                .then(response => response.text())
                .then(gpxData => parseGPX(gpxData))
                .catch(error => console.error('Error fetching GPX file:', error));
        }

        function parseGPX(gpxData) {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(gpxData, 'application/xml');
            const trackpoints = xmlDoc.getElementsByTagName('trkpt');

            let elevations = [];
            let times = [];

            for (let i = 0; i < trackpoints.length; i++) {
                const lat = parseFloat(trackpoints[i].getAttribute('lat'));
                const lon = parseFloat(trackpoints[i].getAttribute('lon'));
                const eleMeters = parseFloat(trackpoints[i].getElementsByTagName('ele')[0].textContent);
                const eleFeet = Math.round(eleMeters * 3.28084);
                const time = new Date(trackpoints[i].getElementsByTagName('time')[0].textContent);

                elevations.push(eleFeet);
                times.push(time);
            }

            const startingElevation = elevations[0];
            const maxElevation = Math.max(...elevations);
            const lowestElevation = Math.min(...elevations);
            const totalDistance = calculateTotalDistance(trackpoints);
            const totalTime = calculateTotalTime(times);

            displayData(startingElevation, maxElevation, lowestElevation, totalDistance, totalTime);
        }

        function calculateTotalDistance(trackpoints) {
            let totalDistance = 0;
            for (let i = 1; i < trackpoints.length; i++) {
                const lat1 = parseFloat(trackpoints[i-1].getAttribute('lat'));
                const lon1 = parseFloat(trackpoints[i-1].getAttribute('lon'));
                const lat2 = parseFloat(trackpoints[i].getAttribute('lat'));
                const lon2 = parseFloat(trackpoints[i].getAttribute('lon'));
                totalDistance += getDistanceFromLatLonInMiles(lat1, lon1, lat2, lon2);
            }
            return totalDistance.toFixed(1) + ' miles';
        }

        function getDistanceFromLatLonInMiles(lat1, lon1, lat2, lon2) {
            const R = 3959; // Radius of the Earth in miles
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a = 
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        function calculateTotalTime(times) {
            const startTime = times[0];
            const endTime = times[times.length - 1];
            const diff = endTime - startTime;
            const hours = Math.floor(diff / 3600000);
            const minutes = Math.floor((diff % 3600000) / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            return `${hours}h ${minutes}m ${seconds}s`;
        }

        function displayData(startingElevation, maxElevation, lowestElevation, totalDistance, totalTime) {
            document.getElementById('starting-elevation').textContent = `${startingElevation} feet`;
            document.getElementById('max-elevation').textContent = `${maxElevation} feet`;
            document.getElementById('lowest-elevation').textContent = `${lowestElevation} feet`;
            document.getElementById('total-distance').textContent = totalDistance;
            document.getElementById('total-time').textContent = totalTime;
        }

        // Fetch and process GPX data
        fetchGPX();
    </script>