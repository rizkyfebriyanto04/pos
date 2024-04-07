@extends('master')

@section('content')
    {{-- <h4>
        Selamat Datang produk
    </h4> --}}
    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <button class="btn btn-outline-success" data-bs-toggle="modal"
                    data-bs-target="#inlineForm">
                    <i data-feather="plus"></i>&nbsp;Tambah
                </button>
                <br><br>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Master Kategori</h4>
                        @if (session('success'))
                            <div class="alert alert-success" id="success-alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    {{-- <th>Tanggal Kadaluarsa</th> --}}
                                </tr>
                                @php
                                    $no = 1
                                @endphp
                                @foreach ($data as $d)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $d->namakategori }}</td>
                                    <td>{{ $d->namaproduk }}</td>
                                    {{-- <td>{{ $d->harga }}</td> --}}
                                    <td>
                                        Rp.{{number_format($d->harga,0,'.',',')}}
                                    </td>
                                    <td>{{ $d->stok }}</td>
                                    {{-- <td>{{  date('j F, Y', strtotime($d->tgl_kadaluarsa)) }}</td> --}}
                                    <td>
                                        <form id="delete-form-{{ $d->pmid }}" action="{{ route('produk.hapusproduk', $d->pmid) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data?');" style="border: none; background-color: transparent;">
                                                <i class="badge-circle badge-circle-light-secondary font-medium-1" data-feather="trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--login form Modal -->
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"></h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('produk.action') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="kategori">Kategori Produk <span class="text-danger">*</span></label>
                        <div class="form-group">
                            <select class="form-control" id="kategori" name="position_id">
                                <option value="" selected>-- Pilih --</option>
                                @foreach ($kategori as $k)
                                   <option value="{{ $k->id }}">{{ $k->namakategori }}</option>
                                @endforeach
                             </select>
                        </div>
                        <label for="Name">Name Produk <span class="text-danger">*</span></label>
                        <div class="form-group">
                            <input class="form-control" id="Name" type="text" name="namaproduk" placeholder="Nama Produk"/>
                        </div>
                        <label for="stok">Stok<span class="text-danger">*</span></label>
                        <div class="form-group">
                            <input class="form-control" id="stok" type="number" name="stok" placeholder="Stok"/>
                        </div>
                        <label for="tglexp">Tgl Exp<span class="text-danger">*</span></label>
                        <div class="form-group">
                            <input type="date" name="tgl_exp" class="form-control mb-3 flatpickr-no-config" placeholder="Select date..">
                            {{-- <input class="form-control" id="tglexp" type="number" name="tglexp" placeholder="Tanggal Exp"/> --}}
                        </div>
                        <label for="harga">Harga<span class="text-danger">*</span></label>
                        <div class="form-group">
                            <input class="form-control" id="harga" type="text" name="harga" placeholder="Harga" onkeyup="formatRupiah(this)"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1"
                            data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
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

        function formatRupiah(angka) {
            var number_string = angka.value.replace(/[^,\d]/g, '');

            var split = number_string.split(',');
            var sisa = split[0].length % 3;
            var rupiah = split[0].substr(0, sisa);
            var ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            angka.value = rupiah;
        }
    </script>
@endsection
