

fetch('http://localhost/mtfalcon2.gpx')
.then(response => response.text())
.then(gpxData => {
    try {
        parseGPX(gpxData);
    } catch (error) {
        console.error('Error parsing GPX:', error);
        alert('There was an error processing the GPX file.');
    } finally {
        if (loadingElement) {
            loadingElement.style.display = 'none';
        }
    }
})



function parseGPX(gpxData) {
    const parser = new DOMParser();
    const xmlDoc = parser.parseFromString(gpxData, 'application/xml');
    const trackpoints = xmlDoc.getElementsByTagName('trkpt');

    if (trackpoints.length === 0) {
        throw new Error('No trackpoints found in GPX data.');
    }

    const labels = [];
    const elevations = [];
    let startTime = null;

    for (let i = 0; i < trackpoints.length; i++) {
        const eleElement = trackpoints[i].getElementsByTagName('ele')[0];
        const timeElement = trackpoints[i].getElementsByTagName('time')[0];

        if (eleElement && timeElement) {
            const ele = parseFloat(eleElement.textContent);
            const time = new Date(timeElement.textContent);

            if (i === 0) {
                startTime = time;
            }

            const elapsedTime = time.getTime() - startTime.getTime();
            labels.push(formatElapsedTime(elapsedTime));
            elevations.push(ele);
        }
    }

    createChart(labels, elevations);
}

function formatElapsedTime(elapsedTime) {
    const totalSeconds = Math.floor(elapsedTime / 1000);
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;
    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

function createChart(labels, elevations) {
    const ctx = document.getElementById('gpsChart').getContext('2d');
    const gpsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Elevation',
                    data: elevations,
                    borderColor: 'green',
                    borderWidth: .4,
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
                        text: 'Elevation (m)'
                    }
                }
            }
        }
    });
}

