<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3>Tambah Produk</h3>
            </div>
            <form action="{{ route('product.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" name="name" placeholder="Nama Produk">
                    </div>
                    <div class="mb-3">
                        <label for="price">Harga</label>
                        <input type="number" class="form-control" name="price" placeholder="Harga Produk">
                    </div>
                    <div class="mb-3">
                        <label for="stock">Stok</label>
                        <input type="number" class="form-control" name="stock" placeholder="Jumlah Stok">
                    </div>
                    <div class="mb-3">
                        <label for="category">Kategori</label>
                        <select name="category" class="form-select">
                            <option disabled selected>Pilih Kategori</option>
                            <option value="food">Makanan</option>
                            <option value="beverage">Minuman</option>
                        </select>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card mt-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Daftar Produk Kantin</h3>
                <h5 class="mb-0">
                    @if ($category == 'food')
                        Total Produk Makanan: {{ $totalProducts }}
                    @elseif ($category == 'beverage')
                        Total Produk Minuman: {{ $totalProducts }}
                    @else
                        Total Semua Produk: {{ $totalProducts }}
                    @endif
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-start mb-3 gap-2">
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
            </div>

            @foreach ($canteenProducts as $product)
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $product->name }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h6>Harga: {{ $product->price }}</h6>
                                    <h6>Stok: {{ $product->stock }}</h6>
                                </div>
                                <div class="col d-flex justify-content-end align-items-center">

                                    <span class="badge text-bg-info">{{ $product->category }}</span>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col d-flex justify-content-start">
                                    <button type="submit" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $product->id }}" class="btn btn-warning">Edit</button>

                                    <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                        Edit Activity
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <form action="{{ route('product.update', $product->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name">Nama</label>
                                                            <input type="text" value="{{ $product->name }}"
                                                                class="form-control" name="name"
                                                                placeholder="Nama Produk">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="price">Harga</label>
                                                            <input type="number" value="{{ $product->price }}"
                                                                class="form-control" name="price"
                                                                placeholder="Harga Produk">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="stock">Stok</label>
                                                            <input type="number" value="{{ $product->stock }}"
                                                                class="form-control" name="stock"
                                                                placeholder="Jumlah Stok">
                                                        </div>
                                                        <div class="mb-3">
                                                            <select name="category" class="form-select" required>
                                                                <option value="" disabled selected>Pilih Kategori
                                                                </option>
                                                                <option value="food">Makanan</option>
                                                                <option value="beverage">Minuman</option>
                                                            </select>


                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>

                                                        <button type="submit" class="btn btn-primary">
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col d-flex justify-content-end">

                                    <button type="submit" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $product->id }}"
                                        class="btn btn-danger">Hapus</button>

                                    <div class="modal fade" id="delete{{ $product->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Produk
                                                        Kantin</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapusnya?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <form action="{{ route('product.destroy', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
