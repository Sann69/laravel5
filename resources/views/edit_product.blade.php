<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">

        <div class="row">
            <div class="col-md-4 offset-4 rounded bg-info mt-3 py-3">
                <h2 class="text-center fw-bold" style="font-size: 20px">Edit Data Produk {{ $product->id }}</h2>

                <form class="mt-3 needs-validation" enctype="multipart/form-data"
                    action="{{ route('update_product', ['product' => $product->id, 'user' => $user->id]) }}"
                    method="POST" novalidate>
                    @method('PUT')
                    @csrf

                    <div class="mb-1">
                        <label for="gambar" class="form-label fw-semibold">Gambar Produk</label>
                        <input type="file" class="form-control" name="gambar" id="gambar">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-1">
                        <label for="nama" class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama produk"
                            value="{{ $product->nama }}" required>
                        <div class="invalid-feedback">Kolom Nama wajib diisi</div>
                    </div>

                    <div class="mb-1">
                        <label for="berat" class="form-label fw-semibold">Berat</label>
                        <input type="number" class="form-control" name="berat" placeholder="Masukkan berat produk"
                            value="{{ $product->berat }}" required>
                        <div class="invalid-feedback">Kolom Berat wajib diisi</div>
                    </div>

                    <div class="mb-1">
                        <label for="harga" class="form-label fw-semibold">Harga</label>
                        <input type="number" class="form-control" name="harga" placeholder="Masukkan harga produk"
                            value="{{ $product->harga }}" required>
                        <div class="invalid-feedback">Kolom Harga wajib diisi</div>
                    </div>

                    <div class="mb-1">
                        <label for="stok" class="form-label fw-semibold">Stok</label>
                        <input type="number" class="form-control" name="stok" placeholder="Masukkan stok produk"
                            value="{{ $product->stok }}" required>
                        <div class="invalid-feedback">Kolom Stok wajib diisi</div>
                    </div>

                    <div class="mb-1">
                        <label for="kondisi" class="form-label fw-semibold">Kondisi</label>
                        <select class="form-select" id="kondisi" name="kondisi" required>
                            <option value="Baru" {{ $product->kondisi == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Bekas" {{ $product->kondisi == 'Bekas' ? 'selected' : '' }}>Bekas</option>
                        </select>
                        <div class="invalid-feedback">Kolom Kondisi wajib diisi</div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"
                            placeholder="Tuliskan deskripsi produk yang akan dijual" required>{{ $product->deskripsi }}</textarea>
                        <div class="invalid-feedback">Kolom Deskripsi wajib diisi</div>
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

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
