@extends('master')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Penjualan</h4>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="basicInput">Barang</label>
                        <select class="form-control" id="basicInput" name="barang" onchange="updateStokAndName()">
                            <option value="">Pilih Barang</option>
                            @foreach($data as $item)
                                <option value="{{ $item->id }}" data-namaproduk="{{ $item->namaproduk }}" data-stok="{{ $item->stok }}" data-harga="{{ $item->harga }}">{{ $item->namaproduk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="buttons">
                        <div class="section-title mt-0">Stok</div>
                        <div class="col-6">
                            <button type="button" class="btn btn-primary" id="buttonStok">
                                <span id="namaProduk"></span><span class="badge bg-transparent" id="stok"></span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlahInput">Jumlah</label>
                        <input type="number" class="form-control" id="jumlahInput" placeholder="Jumlah">
                    </div>
                    <div class="form-group">
                        <label for="hargaInput">Harga</label>
                        <input type="number" class="form-control" id="hargaInput" placeholder="Harga">
                    </div>
                    <div class="buttons">
                        <button type="button" class="btn btn-primary" id="addProductBtn" onclick="addProductToDataTable()">Tambah Produk</button>
                    </div>
                </div>
                <div class="col-md-8">
                    {{-- <div class="form-group">
                        <label for="disabledInput">No Invoice</label>
                        <input type="text" class="form-control" id="disabledInput" placeholder="Disabled Text" value="{{ $no_invoice }}"
                            disabled>
                    </div> --}}
                    <div class="form-group">
                        <div class="row" id="table-head">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Barang</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="dataTableBody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Rp</span>
                        <input type="text" class="form-control" placeholder="bayar"
                            aria-label="bayar" aria-describedby="basic-addon1" id="bayarInput">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <h3>Total</h3> &nbsp;&nbsp;
                        <h3>:</h3> &nbsp;&nbsp;
                        <h3 id="totaltabel">Rp. 0</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="roundText">Keterangan</label>
                        <input type="text" id="roundText" class="form-control round"
                            placeholder="Keterangan">
                    </div>
                </div>
                <div class="col-md-4" style="padding-top: 2%">
                    <div class="buttons">
                        <a href="#" class="btn btn-primary col-12" id="selesaiBtn">Selesai</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateStokAndName() {
    var selectedOption = document.getElementById("basicInput").options[document.getElementById("basicInput").selectedIndex];
    var namaProduk = selectedOption.getAttribute("data-namaproduk");
    var stok = selectedOption.getAttribute("data-stok");
    var harga = selectedOption.getAttribute("data-harga");
    document.getElementById("namaProduk").innerText = namaProduk;
    document.getElementById("stok").innerText = stok;
    document.getElementById("hargaInput").value = harga;
    document.getElementById("jumlahInput").value = "";
}

function addProductToDataTable() {
    var selectedOption = document.getElementById("basicInput").options[document.getElementById("basicInput").selectedIndex];
    var idProduk = selectedOption.value;
    var namaProduk = document.getElementById("namaProduk").innerText;
    var jumlah = document.getElementById("jumlahInput").value;
    var harga = document.getElementById("hargaInput").value;
    var total = jumlah * harga;

    var stokElem = document.getElementById("stok");
    var stok = parseInt(stokElem.innerText);
    var newStok = stok - parseInt(jumlah);

    if (newStok < 0) {
        alert("Stok tidak mencukupi!");
        return;
    }

    stokElem.innerText = newStok;

    var table = document.getElementById("dataTableBody");
    var newRow = table.insertRow(table.rows.length);

    var cellNum = newRow.insertCell(0);
    var cellNamaProduk = newRow.insertCell(1);
    var cellJumlah = newRow.insertCell(2);
    var cellHarga = newRow.insertCell(3);
    var cellTotal = newRow.insertCell(4);
    var cellDelete = newRow.insertCell(5);

    cellNum.innerHTML = table.rows.length;
    cellNamaProduk.innerHTML = namaProduk;
    cellJumlah.innerHTML = jumlah;
    cellHarga.innerHTML = harga;
    cellTotal.innerHTML = total;

    var deleteButton = createDeleteButton(newRow);
    cellDelete.appendChild(deleteButton);

    var rowData = {
        'idproduk': idProduk,
        'namaProduk': namaProduk,
        'jumlah': jumlah,
        'harga': harga,
        'total': total
    };

    document.getElementById("namaProduk").innerText = "";
    document.getElementById("jumlahInput").value = "";
    document.getElementById("hargaInput").value = "";

    updateTotal();
}

function createDeleteButton(row) {
    var button = document.createElement("button");
    button.innerHTML = "Hapus";
    button.onclick = function() {
        hapusBaris(row);
    };
    return button;
}

function hapusBaris(row) {
    var index = row.rowIndex;
    var table = document.getElementById("dataTableBody");
    var cells = row.getElementsByTagName("td");

    var stokElem = document.getElementById("stok");
    var stok = parseInt(stokElem.innerText);
    var jumlahDihapus = parseInt(cells[2].innerText);
    stokElem.innerText = stok + jumlahDihapus;

    table.deleteRow(index);
    updateTotal();
}


function updateTotal() {
    var table = document.getElementById("dataTableBody");
    var rows = table.getElementsByTagName("tr");
    var total = 0;

    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName("td");
        var totalCell = cells[4];
        total += parseFloat(totalCell.innerText);
    }

    var bayarInput = document.getElementById("bayarInput").value;
    if (bayarInput === "") {
        alert("Silakan isi jumlah pembayaran terlebih dahulu!");
        return;
    }

    var bayar = parseFloat(bayarInput);
    if (bayar < total) {
        alert("Jumlah pembayaran kurang dari total!");
        return;
    }

    document.getElementById("totaltabel").innerText = "Rp. " + total.toLocaleString();
}
function updateTotal() {
    var table = document.getElementById("dataTableBody");
    var rows = table.getElementsByTagName("tr");
    var total = 0;

    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName("td");
        var totalCell = cells[4];
        total += parseFloat(totalCell.innerText);
    }
    document.getElementById("totaltabel").innerText = "Rp. " + total.toLocaleString();
}

document.getElementById("selesaiBtn").addEventListener("click", function() {
    var bayarInput = document.getElementById("bayarInput").value;
    if (bayarInput === "") {
        alert("Silakan isi jumlah pembayaran terlebih dahulu!");
        return;
    }

    var dataToSend = [];
    var table = document.getElementById("dataTableBody");
    var rows = table.getElementsByTagName("tr");

    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName("td");
        var selectedOption = document.getElementById("basicInput").options[document.getElementById("basicInput").selectedIndex];
        var idProduk = selectedOption.value;

        var rowData = {
            'idproduk': idProduk,
            'namaProduk': cells[1].innerText,
            'jumlah': cells[2].innerText,
            'harga': cells[3].innerText,
            'total': cells[4].innerText
        };
        dataToSend.push(rowData);
    }

    // var noInvoice = document.getElementById("disabledInput").value;

    $.ajax({
        type: "POST",
        url: "{{ route('penjualan.add') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'data': JSON.stringify(dataToSend),
            'keterangan': document.getElementById("roundText").value,
            // 'no_invoice': noInvoice,
            'bayar': bayarInput
        },
        success: function(response) {
            console.log(response);
            setTimeout(function() {
                location.reload();
            }, 2000);

            if (confirm("Apakah Anda ingin mencetak struk transaksi?")) {
                var url = "{{ route('penjualan.cetakbill') }}?noinvoice=" + response.no_invoice;
                window.open(url, '_blank');
            }
        },

        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});



</script>
@endsection
