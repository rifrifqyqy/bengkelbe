<div class="container mt-5">
    <form action="services/submit_produk.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="produk_name" class="form-label">Nama Produk:</label>
            <input type="text" id="produk_name" name="produk_name" class="form-control px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi:</label>
            <textarea id="description" name="description" class="form-control px-3 py-2" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga:</label>
            <input type="number" id="price" name="price" class="form-control px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Gambar:</label>
            <input type="file" id="image" name="image" class="form-control py-2 px-4" accept="image/*" onchange="previewImage(event)" required>
        </div>
        <div id="imagePreviewContainer" class="mb-3 d-none position-relative">
            <img id="imagePreview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;" />
            <button type="button" class="btn-close position-absolute top-0 mr-3 translate-middle" aria-label="Close" onclick="removeImage()"></button>
        </div>
        <button type="submit" class="btn btn-primary px-3 py-2">Tambah Produk</button>
    </form>
</div>

<!-- script -->
<script>
    function previewImage(event) {
        const imageInput = event.target;
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');

        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.classList.remove('d-none');
            };

            reader.readAsDataURL(imageInput.files[0]);
        }
    }

    function removeImage() {
        const imageInput = document.getElementById('image');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.value = ''; // Menghapus file dari input
        imagePreview.src = ''; // Menghapus gambar dari pratinjau
        imagePreviewContainer.classList.add('d-none'); // Sembunyikan kontainer pratinjau
    }
</script>