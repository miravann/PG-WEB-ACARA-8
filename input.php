<?php
$kecamatan = $_POST['kecamatan'];
$luas = $_POST['luas'];
$jumlah_penduduk = $_POST['jumlah_penduduk'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "penduduk";

// Create connection with error handling
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL with all columns
    $sql = "INSERT INTO penduduk (kecamatan, luas, jumlah_penduduk, latitude, longitude) 
            VALUES (?, ?, ?, ?, ?)";
    
    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddd", $kecamatan, $luas, $jumlah_penduduk, $latitude, $longitude);
    
    // Execute statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}