<?php
session_start();

include("connection.php");
include("functions.php");

?>

<script>

fetch('http://localhost/mtfalcon.gpx')
  .then(response => response.text())
  .then(gpxData => {
    // Parse the GPX data and extract coordinates
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(gpxData, 'text/xml');

    // Extract coordinates and elevation from trackpoints
    var trackpoints = xmlDoc.getElementsByTagName('trkpt');
    var times = [];
    var elevations = [];
    for (var i = 0; i < trackpoints.length; i++) {
        var time = trackpoints[i].getElementsByTagName('time')[0].textContent;
        var elevation = trackpoints[i].getElementsByTagName('ele')[0].textContent;
        times.push(new Date(time));
        elevations.push(parseFloat(elevation));
    }

    // Create the chart
    createChart(times, elevations);
  })
  .catch(error => {
    console.error('Failed to fetch GPX file:', error);
  });

function createChart(labels, data) {
    var ctx = document.getElementById('elevationChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Elevation (m)',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                lineTension: 0.1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'minute',
                        tooltipFormat: 'll HH:mm'
                    },
                    title: {
                        display: true,
                        text: 'Time'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Elevation (m)'
                    }
                }
            }
        }
    });
}
</script>