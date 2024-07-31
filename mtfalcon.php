<!DOCTYPE html>	
<head>
   



<title>Mt Falcon Park</title>

<link rel="stylesheet" href="style.css">	
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="nav.js" defer></script>
<script src="parseGPX.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
 <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>


    
<a href="index.html"><p class="logged-top-logo">vid<span class="red">e</span>rth</p>


<p class="post-scroll-title">Mt Falcon Park</p></a>
					    <div class="user-id-block">
							<img class="profile-pic" src="images/profilepic.jpg">				
							
							<div class="user-id">
								<p class="post-author">MountainMan01</p>
								<p class="activity-count">2 adventures</p>
                            </div>	
                        </div>


<div class="post-content-column">

<p class ="adventure-description">Mt Falcon Park has amazing views and ample parking.  Lots of picknicking areas to choose from.  There are also restrooms provided.  You can add on miles and explore other parts fo the Park</p>
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
    <iframe  class="post-video" src="https://www.youtube.com/embed/7wlTG3RSPJc" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe><br>
				            
    <div class="map-google" id="map"></div>

  
    <div id="chart-container">
        <canvas id="gpsChart"></canvas>
    </div>
    </div>
    <!-- JavaScript Libraries -->
  
    <script>
        // URL to your GPX file
        const gpxUrl = 'http://localhost/mtfalcon2.gpx';

        // Fetch and process GPX data
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

            if (trackpoints.length === 0) {
                throw new Error('No trackpoints found in GPX data.');
            }

            const labels = [];
            const elevations = [];
            const coordinates = [];
            let startTime = null;
            let minElevation = Infinity;
            let maxElevation = -Infinity;
            let endTime = null;

            for (let i = 0; i < trackpoints.length; i++) {
                const lat = parseFloat(trackpoints[i].getAttribute('lat'));
                const lon = parseFloat(trackpoints[i].getAttribute('lon'));
                const eleElement = trackpoints[i].getElementsByTagName('ele')[0];
                const timeElement = trackpoints[i].getElementsByTagName('time')[0];

                if (eleElement && timeElement) {
                    const ele = parseFloat(eleElement.textContent);
                    const time = new Date(timeElement.textContent);

                    if (i === 0) {
                        startTime = time;
                    }

                    endTime = time;

                    const elapsedTime = time.getTime() - startTime.getTime();
                    labels.push(formatElapsedTime(elapsedTime));

                    const eleFeet = Math.round(ele * 3.28084);
                    elevations.push(eleFeet);

                    minElevation = Math.min(minElevation, eleFeet);
                    maxElevation = Math.max(maxElevation, eleFeet);
                    coordinates.push([lat, lon]);
                }
            }

            const totalDistance = calculateTotalDistance(coordinates);
            const totalTime = startTime && endTime ? calculateTotalTime(startTime, endTime) : 'N/A';

            displayData(elevations[0], maxElevation, minElevation, totalDistance, totalTime);
            drawMap(coordinates);
            createChart(labels, elevations);
        }

        function formatElapsedTime(elapsedTime) {
            const totalSeconds = Math.floor(elapsedTime / 1000);
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        function calculateTotalDistance(coordinates) {
            let totalDistance = 0;
            for (let i = 1; i < coordinates.length; i++) {
                const [lat1, lon1] = coordinates[i-1];
                const [lat2, lon2] = coordinates[i];
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

        function calculateTotalTime(startTime, endTime) {
            const diff = endTime - startTime;
            const hours = Math.floor(diff / 3600000);
            const minutes = Math.floor((diff % 3600000) / 60000);
            return `${hours}h ${minutes}m`;
        }

        function displayData(startingElevation, maxElevation, lowestElevation, totalDistance, totalTime) {
            document.getElementById('starting-elevation').textContent = `${startingElevation} feet`;
            document.getElementById('max-elevation').textContent = `${maxElevation} feet`;
            document.getElementById('lowest-elevation').textContent = `${lowestElevation} feet`;
            document.getElementById('total-distance').textContent = totalDistance;
            document.getElementById('total-time').textContent = totalTime;
        }

        function drawMap(coordinates) {
            const map = L.map('map').setView(coordinates[0], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            const polyline = L.polyline(coordinates, { color: 'blue' }).addTo(map);
            map.fitBounds(polyline.getBounds());
        }

        function createChart(labels, elevations) {
            const ctx = document.getElementById('gpsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Elevation',
                            data: elevations,
                            borderColor: 'green',
                            borderWidth: 1,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'category',
                            title: {
                                display: true,
                                text: 'Elapsed Time'
                            }
                        },
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Elevation (feet)'
                            }
                        }
                    }
                }
            });
        }

        // Fetch and process GPX data on page load
        fetchGPX();
    </script>
</body>
</html>