-- Updated to match the column names used in your PHP code
CREATE DATABASE IF NOT EXISTS gps_tracker;
USE gps_tracker;

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Changed column names to match PHP code
CREATE TABLE IF NOT EXISTS gps_track (
    track_id INT AUTO_INCREMENT PRIMARY KEY,
    rider_id INT NOT NULL,  -- Changed from user_id
    track_lat DOUBLE NOT NULL,  -- Changed from latitude
    track_lng DOUBLE NOT NULL,  -- Changed from longitude
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rider_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Updated sample data to match new column names
INSERT INTO users (name, email, password) VALUES
('Shruti Thakur', 'shruti@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Rider Tommar', 'rider@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO gps_track (rider_id, track_lat, track_lng) VALUES
(1, 37.7749, -122.4194),
(2, 34.0522, -118.2437);