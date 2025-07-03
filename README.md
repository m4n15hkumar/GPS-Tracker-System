A web-based real-time GPS tracking system that captures and displays the live locations of riders (users) via a client-side tracking page and a centralized admin monitoring dashboard.

🚀 Features
🔄 Live Location Tracking using the browser's Geolocation API

📡 Real-Time Updates via continuous POST requests from client to server

🧑‍💼 Admin Panel to view all active rider locations with auto-refresh

🛡️ Secure Backend using PHP, MySQL (PDO), and input validation

🗃️ Centralized Error Logging and Config Management

📁 Modular file structure for frontend, backend, and database operations

🛠️ Tech Stack
Layer	Technology
Frontend	HTML, CSS, JavaScript (Geolocation API)
Backend	PHP (REST API with secure PDO)
Database	MySQL
Admin Panel	JavaScript, Fetch API
Server	XAMPP (localhost)

📂 Project Structure
bash
Copy code
/gps-tracker
│
├── admin.html          # Admin dashboard UI
├── track.html          # Client-side tracking page
├── track.js            # JavaScript for sending rider coordinates
├── 4b-admin.js         # Admin panel JS to fetch rider data
├── track-api.php       # API endpoint for tracking (GET, POST)
├── 2-lib-track.php     # DB functions for storing and retrieving locations
├── config.php          # Central DB config and logging setup
├── X-demo.css          # Common styles
└── php-errors.log      # Error log file
🧪 How It Works
Rider (User Side):

Opens track.html, which uses the Geolocation API to get current coordinates.

Sends rider_id, latitude, and longitude to track-api.php.

Admin Side:

Opens admin.html to see all riders’ data, updated every 10 seconds.

Fetches and renders real-time data using fetch() from the backend API.

Backend (track-api.php):

Processes POST requests for location updates.

Processes GET requests to serve all rider data to admin.

Communicates with MySQL DB via secure functions in 2-lib-track.php.

🧩 Future Improvements
🔐 Add login authentication for riders and admins

🗺️ Integrate Google Maps or Leaflet.js for live map display

📲 Convert to mobile-first UI design

🌐 Host on live web server (e.g., AWS, Render, etc.)

📸 Screenshots
(You can add screenshots here later by uploading images and linking them)

✅ Setup Instructions
Install XAMPP and start Apache & MySQL

Place all files inside htdocs/gps-tracker directory

Create a MySQL database and import gps_track and users tables

Configure database credentials in config.php

Open track.html (user) and admin.html (admin) in your browser
