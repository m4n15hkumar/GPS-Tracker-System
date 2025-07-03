<?php
require "config.php";
require "2-lib-track.php";

// Get the request type
$req = $_POST["req"] ?? "";

switch ($req) {
  // Get all rider locations
  case "get":
    try {
      $data = $_TRACK->getLocations();
      if ($data === false) {
        throw new Exception("Failed to get locations: " . $_TRACK->error);
      }
      echo json_encode([
        "status" => 1,
        "count" => count($data),
        "data" => $data
      ]);
    } catch (Exception $e) {
      error_log("API Error: " . $e->getMessage());
      echo json_encode([
        "status" => 0,
        "error" => $e->getMessage()
      ]);
    }
    break;

  // Update rider location
  case "update":
    try {
      $id = $_POST["id"] ?? null;
      $lat = $_POST["lat"] ?? null;
      $lng = $_POST["lng"] ?? null;

      if (!$id || !$lat || !$lng) {
        throw new Exception("Missing parameters");
      }

      if (!$_TRACK->updateLocation($id, $lat, $lng)) {
        throw new Exception("Update failed: " . $_TRACK->error);
      }
      echo "OK";
    } catch (Exception $e) {
      error_log("API Error: " . $e->getMessage());
      echo "ERROR";
    }
    break;

  // Unknown request
  default:
    echo "Invalid request";
}
?>