@extends('master')

@section('content')
    {{-- <h4>
        Selamat Datang kategori
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
                                    <th>Nama Kategori</th>
                                </tr>
                                @php
                                    $no = 1
                                @endphp
                                @foreach ($data as $d)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $d->namakategori }}</td>
                                    <td>
                                        <form id="delete-form-{{ $d->id }}" action="{{ route('kategori.hapus', $d->id) }}" method="POST" style="display: inline;">
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
                <form action="{{ route('kategori.action') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="Name">Name Kategori <span class="text-danger">*</span></label>
                        <div class="form-group">
                            <input class="form-control" id="Name" type="text" name="namakategori" value="{{ old('namakategori') }}" placeholder="Nama Kategori"/>
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
    </script>
@endsection
