@extends('master')

@section('content')
    {{-- <h4>
        Selamat Datang registrasi
    </h4> --}}
    <!-- Table head options start -->
    <section class="section">
        <div class="row" id="table-head">
            <form action="{{ route('laporan') }}" method="GET" class="row">
                <div class="col-4">
                    <label for="">Tanggal Awal</label>
                    <input type="date" name="tglawal" class="form-control mb-3 flatpickr-no-config" placeholder="Pilih Tanggal">
                </div>
                <div class="col-4">
                    <label for="">Tanggal Akhir</label>
                    <input type="date" name="tglakhir" class="form-control mb-3 flatpickr-no-config" placeholder="Pilih Tanggal">
                </div>
                <div class="col-2 mt-4">
                    <label for="">&nbsp;</label>
                    <button type="submit" class="btn btn-primary ms-1">
                        <span class="d-none d-sm-block">Cari</span>
                    </button>
                </div>
            </form>
            <div class="col-12">
                {{-- <button class="btn btn-outline-success" data-bs-toggle="modal"
                    data-bs-target="#inlineForm">
                    <i data-feather="plus"></i>&nbsp;Tambah
                </button>
                <br><br> --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Penjualan</h4>
                        @if (session('success'))
                            <div class="alert alert-success" id="success-alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        {{-- <th>No Invoice</th> --}}
                                        <th>Kategori</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Total</th>
                                        <th>Tanggal Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                        $prevInvoice = null;
                                    @endphp
                                    @foreach ($data as $d)
                                        @if ($prevInvoice !== $d->no_penjualan)
                                            <tr>
                                                <td colspan="8" class="invoice-header">No. Invoice : {{ $d->no_penjualan }}</td>
                                            </tr>
                                            @php
                                                $prevInvoice = $d->no_penjualan;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            {{-- <td>{{ $d->no_penjualan }}</td> --}}
                                            <td>{{ $d->namakategori }}</td>
                                            <td>{{ $d->namaproduk }}</td>
                                            <td>{{ $d->qty }}</td>
                                            <td>Rp.{{number_format($d->harga,0,'.',',')}}</td>
                                            <td>Rp.{{number_format($d->qty * $d->harga,0,'.',',')}}</td>
                                            <td>{{ $d->tanggal_jual }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

    <script>
        // Ambil elemen alert
        var alertBox = document.getElementById('success-alert');

        // Sembunyikan elemen alert setelah 3 detik
        setTimeout(function() {
            alertBox.style.display = 'none';
        }, 3000);
    </script>
    <!-- Table head options end -->
@endsection
