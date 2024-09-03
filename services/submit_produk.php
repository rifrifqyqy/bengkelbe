<?php
// Menginclude file config.php untuk koneksi database
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['produk_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Mengupload file
    $target_dir = "../uploads/";
    $filename = basename($_FILES["image"]["name"]);
    $file_path = 'uploads/' . $filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $filename)) {
        // Simpan informasi file ke dalam tb_images
        $sql_image = "INSERT INTO tb_img (file_name, file_path) VALUES ('$filename', '$file_path')";

        if ($conn->query($sql_image) === TRUE) {
            $image_id = $conn->insert_id; // Mendapatkan ID image yang baru saja disimpan

            // Simpan data produk ke dalam database
            $sql_produk = "INSERT INTO produk (produk_name, description, price, image_id) 
                            VALUES ('$nama_produk', '$description', '$price', '$image_id')";

            if ($conn->query($sql_produk) === TRUE) {
                echo "Data produk berhasil disimpan.";
            } else {
                echo "Error: " . $sql_produk . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql_image . "<br>" . $conn->error;
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload file.";
    }
}

$conn->close();
header("Location: ../daftarproduk");
