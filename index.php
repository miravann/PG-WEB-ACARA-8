<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penduduk per Kecamatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9f5e9; /* Latar belakang hijau muda */
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 80%; /* Ukuran tabel lebih sempit */
            margin: 0 auto; /* Centering the table */
            border-collapse: collapse;
            font-size: 18px;
            background-color: #fefefe; /* Latar belakang tabel */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            outline: 2px solid #4CAF50; /* Garis outline berwarna hijau */
            transition: transform 0.2s; /* Animasi saat hover */
        }

        table:hover {
            transform: scale(1.02); /* Sedikit membesar saat kursor di atas */
        }

        table thead {
            background-color: #87ceeb;
            color: white;
        }

        table th, table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        table tr:hover {
            background-color: #f1f1f1; /* Warna latar belakang saat hover pada baris */
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table td a {
            color: #ff5c5c; /* Warna link */
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s; /* Animasi saat hover pada link */
        }

        table td a:hover {
            color: #ff1a1a; /* Warna link saat hover */
        }

        table th, table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: center; /* Memusatkan teks */
        }

    </style>
</head>
<body>

<h1>Data Penduduk per Kecamatan</h1>

<?php
// Sesuaikan dengan setting MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgwebacara8";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk menghapus data jika tombol Delete ditekan
if (isset($_GET['delete'])) {
    $kecamatan_to_delete = $_GET['delete'];
    $delete_sql = "DELETE FROM penduduk WHERE kecamatan='$kecamatan_to_delete'";
    
    if ($conn->query($delete_sql) === TRUE) {
        echo "<p style='color: green; text-align: center;'>Record deleted successfully</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error deleting record: " . $conn->error . "</p>";
    }
}

// Query data dari tabel penduduk
$sql = "SELECT kecamatan, longitude, latitude, luas, jumlah_penduduk FROM penduduk";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
    <thead>
    <tr>
    <th>Kecamatan</th>
    <th>Longitude</th>
    <th>Latitude</th>
    <th>Luas</th>
    <th>Jumlah Penduduk</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>";
    
    // Output data per baris
    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>".$row["kecamatan"]."</td>
        <td>".$row["longitude"]."</td>
        <td>".$row["latitude"]."</td>
        <td>".$row["luas"]."</td>
        <td align='right'>".$row["jumlah_penduduk"]."</td>
        <td><a href='?delete=".$row["kecamatan"]."' onclick=\"return confirm('Are you sure you want to delete this item?');\">Delete</a></td>
        </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p style='text-align: center;'>0 results</p>";
}

// Tutup koneksi
$conn->close();
?>

</body>
</html>