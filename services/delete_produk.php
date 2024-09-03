<?php
include 'config.php';


$id_produk = $_GET['id_produk'];

$query = "DELETE from produk where id = '$id_produk'";
mysqli_query($conn, $query);

// mengalihkan
header("location:../daftarproduk");
