<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">

        <div class="row">
            <div class="col-md-4 offset-4 rounded bg-info mt-3 py-3">

                <h2 class="text-center fw-bold" style="font-size: 20px">Tambah Data Produk</h2>

                <form class="mt-3 needs-validation" enctype="multipart/form-data"
                    action="{{ route('postRequest', ['user' => $user->id]) }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-1">
                        <label for="gambar" class="form-label fw-semibold">Gambar Produk</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" required>
                        <div class="invalid-feedback">Kolom Gambar wajib diisi</div>
                    </div>

                    <div class="mb-1">
                        <label for="nama" class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" class="form-control" name="nama" id="nama"
                            value="{{ old('nama') }}" placeholder="Masukkan nama produk" required>
                        <div class="invalid-feedback">Kolom Nama wajib diisi</div>
                    </div>

                    <div class="mb-1">
                        <label for="berat" class="form-label fw-semibold">Berat</label>
                        <input type="number" class="form-control" name="berat" id="berat"
                            value="{{ old('berat') }}" placeholder="Masukkan berat produk" required>
                        <div class="invalid-feedback">Kolom Berat wajib diisi</div>
                    </div>

                    <div class="mb-1">
                        <label for="harga" class="form-label fw-semibold">Harga</label>
                        <input type="number" class="form-control" name="harga" id="harga"
                            value="{{ old('harga') }}" placeholder="Masukkan harga produk" required>
                        <div class="invalid-feedback">Kolom harga wajib diisi</div>
                    </div>

                    <div class="mb-1">
                        <label for="stok" class="form-label fw-semibold">Stok</label>
                        <input type="number" class="form-control" name="stok" id="stok"
                            value="{{ old('stok') }}" placeholder="Masukkan stok produk" required>
                        <div class="invalid-feedback">Kolom Stok wajib diisi</div>
                    </div>

                    <div class="mb-1">
                        <label for="kondisi" class="form-label fw-semibold">Kondisi</label>
                        <select class="form-select form-control" aria-label="Default select example" name="kondisi"
                            id="kondisi" required>
                            <option selected disabled value="">Pilih Kondisi Barang</option>
                            <option value="Baru" {{ old('kondisi') == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Bekas" {{ old('kondisi') == 'Bekas' ? 'selected' : '' }}>Bekas</option>
                        </select>
                        <div class="invalid-feedback">Kolom Kondisi wajib diisi</div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4"
                            placeholder="Tuliskan deskripsi produk yang akan dijual" required></textarea>
                        <div class="invalid-feedback" id="deskripsiFeedback"></div>
                    </div>

                    <div class="d-flex">
                        <button class="btn btn-warning mx-auto" onclick="history.back()">Kembali</button>
                        <button class="btn btn-dark mx-auto" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                // Validasi deskripsi
                const deskripsiInput = form.querySelector('#deskripsi');
                const deskripsiValue = deskripsiInput.value.trim();
                const deskripsiFeedback = form.querySelector('#deskripsiFeedback');

                if (deskripsiValue.length === 0) {
                    deskripsiFeedback.textContent = 'Kolom Deskripsi wajib diisi';
                    event.preventDefault();
                    event.stopPropagation();
                } else if (deskripsiValue.length > 2000) {
                    deskripsiFeedback.textContent = 'Maksimal 2000 Karakter';
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    deskripsiFeedback.textContent = '';
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
