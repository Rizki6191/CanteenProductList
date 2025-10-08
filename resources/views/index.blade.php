<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Produk Kantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light">

    <div class="container mt-5">
        {{-- Notifikasi sukses --}}
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{-- Form Tambah Produk --}}
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Produk</h4>
            </div>
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama Produk">
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" class="form-control" name="price" placeholder="Harga Produk">
                        </div>
                        <div class="col-md-6">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stock" placeholder="Jumlah Stok">
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Kategori</label>
                            <select name="category" class="form-select">
                                <option disabled selected>Pilih Kategori</option>
                                <option value="food">Makanan</option>
                                <option value="beverage">Minuman</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4">Tambah</button>
                </div>
            </form>
        </div>

        {{-- Daftar Produk --}}
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Produk Kantin</h4>
                <h6 class="mb-0">
                    @if ($category == 'food')
                        Total Produk Makanan: {{ $totalProducts }}
                    @elseif ($category == 'beverage')
                        Total Produk Minuman: {{ $totalProducts }}
                    @else
                        Total Semua Produk: {{ $totalProducts }}
                    @endif
                </h6>
            </div>

            <div class="card-body">
                {{-- Filter Kategori --}}
                <div class="d-flex justify-content-start mb-4 gap-2">
                    <a href="{{ route('index') }}"
                        class="btn btn-outline-secondary {{ request('category') == null ? 'active' : '' }}">
                        Semua
                    </a>
                    <a href="{{ route('index', ['category' => 'food']) }}"
                        class="btn btn-outline-primary {{ request('category') == 'food' ? 'active' : '' }}">
                        Food
                    </a>
                    <a href="{{ route('index', ['category' => 'beverage']) }}"
                        class="btn btn-outline-success {{ request('category') == 'beverage' ? 'active' : '' }}">
                        Beverage
                    </a>
                </div>

                {{-- Grid Produk --}}
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($canteenProducts as $product)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="card-img-top" alt="Gambar Produk" 
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center"
                                         style="height: 200px;">
                                        <span class="text-white">Tidak ada gambar</span>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text mb-1">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="card-text">Stok: {{ $product->stock }}</p>
                                    <span class="badge bg-info text-dark">{{ $product->category }}</span>
                                </div>

                                <div class="card-footer d-flex justify-content-between">
                                    <button data-bs-toggle="modal" data-bs-target="#edit{{ $product->id }}"
                                        class="btn btn-warning btn-sm">Edit</button>

                                    <button data-bs-toggle="modal" data-bs-target="#delete{{ $product->id }}"
                                        class="btn btn-danger btn-sm">Hapus</button>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Produk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Nama</label>
                                                <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Harga</label>
                                                <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Stok</label>
                                                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Kategori</label>
                                                <select name="category" class="form-select">
                                                    <option value="food" {{ $product->category == 'food' ? 'selected' : '' }}>Makanan</option>
                                                    <option value="beverage" {{ $product->category == 'beverage' ? 'selected' : '' }}>Minuman</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Gambar</label>
                                                <input type="file" name="image" class="form-control">
                                                @if ($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" class="mt-2 rounded shadow" width="100">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Hapus --}}
                        <div class="modal fade" id="delete{{ $product->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Hapus Produk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah kamu yakin ingin menghapus <b>{{ $product->name }}</b>?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-danger" type="submit">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
