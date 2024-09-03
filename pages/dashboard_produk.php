<?php
include "services/config.php";

// query produk
$produk_query = mysqli_query($conn, "SELECT * FROM produk");
$img_query = mysqli_query($conn, "SELECT * FROM tb_img");
$jumlahData = mysqli_num_rows($produk_query);
// fetch data dari sql db
$produk = [];
// Simpan data gambar dalam array dengan ID sebagai kunci
$images = [];
while ($row = mysqli_fetch_assoc($img_query)) {
    $images[$row['id']] = $row;
}
while ($prods_data = mysqli_fetch_assoc($produk_query)) {
    $prods_data['image'] = isset($images[$prods_data['image_id']]) ? $images[$prods_data['image_id']] : null;
    $produk[] = $prods_data;
}

// buatkan fungsi untuk merubah format menjadi rupiah tanpa ,00
function rupiah($angka)
{
    $rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $rupiah;
}
// fungsi memformat tanggal created_ad menjadi format tgl-bln-tahun  waktu dibuat
function formatCreatedAt($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $tanggalArray = explode(' ', $tanggal);
    $tanggalPart = explode('-', $tanggalArray[0]);

    $tanggalIndo = $tanggalPart[2] . ' ' . $bulan[(int)$tanggalPart[1]] . ' ' . $tanggalPart[0];

    // Jika ingin menambahkan waktu
    if (isset($tanggalArray[1])) {
        $tanggalIndo .= ' ' . $tanggalArray[1];
    }

    return $tanggalIndo;
}
?>


<link rel="stylesheet" href="css/card.css">

<main class="container-fluid mt-4 px-sm-4 px-lg-5 px-3">

    <section class="d-flex justify-content-between">
        <p class="mb-2">Total Produk (<?= $jumlahData ?>)</p>
        <!-- button untuk pindah ke halaman /tambahproduk saat diklik -->
        <a href="/bengkelbe/tambahproduk" class="btn btn-success mb-3">Tambah Produk
        </a>
    </section>

    <div class="row card-data">
        <?php foreach ($produk as $prods): ?>
            <section class="col-md-6 col-lg-6 col-xl-4 mb-4">
                <section class="card-pemesanan">
                    <div class="card-header">
                        <img src="<?= htmlspecialchars($prods['image']['file_path']); ?>" alt="" class="pfp">
                        <div class="card-title">
                            <h5 class="text-truncate name">
                                <?= $prods['produk_name'] ?>
                            </h5>
                            <p class="text-truncate id-pelanggan"><?= $prods['description'] ?></p>
                            <div class="label-wrapper mt-1 d-flex flex-wrap gap-2">

                                <p class="label rounded-pill">Produk Data</p>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h3 class="price my-auto">
                            <?= rupiah($prods['price']) ?>
                        </h3>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-lihat" data-bs-toggle="modal" data-bs-target="#modalPesanan<?= $prods['id'] ?>">
                            Lihat
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modalPesanan<?= $prods['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog fixed">
                                <div class="modal-content p-3">
                                    <div class="modal-header border-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-flex flex-column gap-2">
                                        <main class="">
                                            <aside>
                                                <img src="<?= htmlspecialchars($prods['image']['file_path']); ?>" alt="" class="img-modal rounded-circle">
                                                <p class="id-label rounded-pill">ID Produk <?= $prods['id'] ?></p>
                                                <div class="d-flex flex-column align-items-center">
                                                    <h5 class="text-center"><?= $prods['produk_name'] ?></h5>
                                                    <p></p>
                                                </div>
                                                <section class="d-flex gap-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <h3></h3>
                                                        <p class="person-package">Persons</p>
                                                    </div>
                                                    <div class="divide"></div>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <h3></h3>
                                                        <p class="person-package">Packages</p>
                                                    </div>
                                                </section>
                                                <div class="mt-5 total-price rounded-3"><?= rupiah($prods['price']) ?></div>

                                            </aside>
                                            <section class="field-section">

                                                <article class="field-wrapper" id="single">
                                                    <div class="field">
                                                        <h5>Deskripsi Produk</h5>
                                                        <p><?= htmlspecialchars($prods['description']) ?></p>
                                                    </div>
                                                </article>
                                                <article class="field-wrapper" id="single">
                                                    <div class="field">
                                                        <h5>Tanggal Diupload</h5>
                                                        <p><?= formatCreatedAt($prods['created_at']) ?></p>
                                                    </div>
                                                </article>
                                                <article class="field-wrapper" id="single">
                                                    <div class="field">
                                                        <h5>Harga Paket</h5>
                                                        <p><?= htmlspecialchars(rupiah($prods['price'])) ?></p>
                                                    </div>
                                                </article>

                                            </section>
                                        </main>

                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-between">
                                        <a class="btn btn-delete rounded-2" href='services/delete_produk.php?id_produk=<?= $prods['id'] ?>' onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        <?php endforeach; ?>
    </div>

</main>