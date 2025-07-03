var track = {
    // (A) CONFIGURATION
    rider : 1,   // 🚨 Replace 1 with the actual user ID from your `users` table
    delay : 10000, // GPS update every 10 seconds
    timer : null,  // For storing the interval ID
    hDate : null,  // To hold HTML element for date/time
    hLat : null,   // To hold HTML element for latitude
    hLng : null,   // To hold HTML element for longitude
  
    // (B) INITIALIZATION FUNCTION
    init : () => {
      // Get references to HTML elements
      track.hDate = document.getElementById("date");
      track.hLat = document.getElementById("lat");
      track.hLng = document.getElementById("lng");
  
      // Start updating location immediately and then repeatedly
      track.update();
      track.timer = setInterval(track.update, track.delay);
    },
  
    // (C) UPDATE LOCATION FUNCTION
    update : () => navigator.geolocation.getCurrentPosition(
      pos => {
        // Prepare data to send to server
        var data = new FormData();
        data.append("req", "update");
        data.append("id", track.rider);
        data.append("lat", pos.coords.latitude);
        data.append("lng", pos.coords.longitude);
  
        // Send data to server via fetch()
        fetch("track-api.php", { method: "POST", body: data })
        .then(res => res.text())
        .then(txt => {
          if (txt == "OK") {
            let now = new Date();
            track.hDate.innerHTML = now.toLocaleString();
            track.hLat.innerHTML = pos.coords.latitude.toFixed(6);
            track.hLng.innerHTML = pos.coords.longitude.toFixed(6);
          } else {
            track.error(txt);
          }
        })
        .catch(err => track.error(err));
      },
      err => track.error(err)
    ),
  
    // (D) ERROR HANDLER
    error : err => {
      console.error("Tracking error:", err);
      alert("An error occurred while tracking. Check console for details.");
      clearInterval(track.timer);
    }
  };
  
  // Start tracking on page load
  window.onload = track.init;
  