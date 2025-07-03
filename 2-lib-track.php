<?php
require_once __DIR__ . '/config.php';

class Track {
    private $pdo;
    public $error = '';

    function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME,
                DB_USER, 
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            // Test connection
            $this->pdo->query("SELECT 1")->fetch();
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function updateLocation($user_id, $lat, $lng) {
        try {
            // Validate inputs
            if (!is_numeric($user_id) || !is_numeric($lat) || !is_numeric($lng)) {
                throw new Exception("Invalid parameters");
            }

            $stmt = $this->pdo->prepare(
                "INSERT INTO gps_track (rider_id, track_lat, track_lng) 
                 VALUES (:rider_id, :lat, :lng)"
            );
            
            $stmt->execute([
                ':rider_id' => $user_id,
                ':lat' => $lat,
                ':lng' => $lng
            ]);
            
            return true;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("DB Error [updateLocation]: " . $e->getMessage());
            return false;
        }
    }

    public function getLocations($user_id = null) {
        try {
            $sql = "SELECT 
                        t.track_id,
                        t.rider_id,
                        t.track_lat AS latitude,
                        t.track_lng AS longitude,
                        t.timestamp,
                        u.name,
                        u.email
                    FROM gps_track t
                    JOIN users u ON t.rider_id = u.user_id";
            
            $params = [];
            
            if ($user_id !== null) {
                $sql .= " WHERE t.rider_id = :user_id";
                $params[':user_id'] = $user_id;
            }
            
            $sql .= " ORDER BY t.timestamp DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            $result = $stmt->fetchAll();
            
            if (empty($result)) {
                $this->error = "No locations found";
                return [];
            }
            
            return $result;
            
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("DB Error [getLocations]: " . $e->getMessage());
            return false;
        }
    }

    public function verifyUser($email, $password) {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT user_id, password FROM users WHERE email = :email"
            );
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();
            
            if (!$user) {
                throw new Exception("User not found");
            }
            
            if (password_verify($password, $user['password'])) {
                return $user['user_id'];
            }
            
            throw new Exception("Invalid password");
            
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("DB Error [verifyUser]: " . $e->getMessage());
            return false;
        }
    }
}

// Initialize the tracker
$_TRACK = new Track();
?>