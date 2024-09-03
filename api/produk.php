<?php
// Menginclude file config.php untuk koneksi database
include 'services/config.php';

// Mengatur header agar API dapat diakses dari berbagai domain (CORS) dan mengembalikan JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Query untuk mendapatkan semua data produk beserta informasi gambarnya
$sql = "SELECT p.id, p.produk_name, p.description, p.price, p.created_at, i.file_name, i.file_path 
        FROM produk p 
        JOIN tb_img i ON p.image_id = i.id";

$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    // Mengambil setiap baris data
    while ($row = $result->fetch_assoc()) {
        $product = array(
            "id" => (int)$row["id"],
            "produk_name" => $row["produk_name"],
            "description" => $row["description"],
            "price" => (int)$row["price"],
            "image" => array(
                "file_name" => $row["file_name"],
                "file_path" => $row["file_path"]
            ),
            "created_at" => $row["created_at"]
        );
        array_push($products, $product);
    }
    // Mengembalikan data dalam format JSON
    echo json_encode($products);
} else {
    echo json_encode(array("message" => "Tidak ada data produk ditemukan."));
}

$conn->close();
