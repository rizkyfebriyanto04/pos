<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title}}</title>
</head>
<style>
</style>
<body onLoad="window.print()">
    <table border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
            <td>
                <br>
            </td>
            </tr>
          <tr>
            <td></td>
            <td>MY POS APP</td>
            <td></td>
          </tr>
          <tr>
            <td>
                <br>
            </td>
          </tr>
          <tr>
            <td>Receipt No.</td>
            <td></td>
            <td>{{ $data[0]->no_penjualan }}</td>
          </tr>
          <tr>
            <td>Cashier</td>
            <td></td>
            <td>administrator</td>
          </tr>
          <tr>
            <td>Order Date</td>
            <td></td>
            <td align="right">{{ $data[0]->tanggal_jual }}</td>
          </tr>
          <tr>
            {{-- <td>hr</td>
            <td>hr</td>
            <td>hr</td> --}}
            <td colspan="3">
                <hr>
            </td>
          </tr>
          <tr>
            <td align="center" colspan="3">PAID</td>
          </tr>
          <tr>
            <td colspan="3">
                <hr>
            </td>
          </tr>
          @foreach ($data as $item)
            <tr>
                <td>
                    {{ $item->namaproduk }}
                </td>
                <td>
                    x{{ $item->qty }}
                </td>
                <td>
                    {{ $item->total }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>
            @php
                $subtotal = 0; // Inisialisasi subtotal
            @endphp
            @foreach ($data as $item)
            @php
                $subtotal += $item->total; // Tambahkan total produk ke subtotal
            @endphp
            @endforeach
            <tr>
                <td>Subtotal</td>
                <td></td>
                <td>{{ $subtotal }}</td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td></td>
                <td>{{ $data[0]->bayar }}</td> <!-- Anda mungkin perlu menyesuaikan ini dengan cara yang sesuai -->
            </tr>
            <tr>
                <td>Kembalian</td>
                <td></td>
                <td>{{ $subtotal - $data[0]->bayar }}</td> <!-- Anda mungkin perlu menyesuaikan ini dengan cara yang sesuai -->
            </tr>
          <tr>
            <td>
                <br>
            </td>
          </tr>
          <tr>
            <td align="center" colspan="3">Thans for Order</td>
          </tr>
        </tbody>
    </table>
</body>
</html>
