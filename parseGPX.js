function parsemGPX(gpxData) {
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(gpxData, "text/xml");
    var trackpoints = xmlDoc.querySelectorAll("trkpt");
    var coordinates = [];
    trackpoints.forEach(function(trackpoint) {
      var lat = parseFloat(trackpoint.getAttribute("lat"));
      var lon = parseFloat(trackpoint.getAttribute("lon"));
      coordinates.push([lat, lon]);
    });
    return coordinates;
  }
  
