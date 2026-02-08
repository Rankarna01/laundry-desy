<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk - {{ $trx->kode_transaksi }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Font struk */
            font-size: 14px;
            color: #333;
            max-width: 300px; /* Lebar struk thermal standar */
            margin: 0 auto;
            padding: 20px;
            background: #fff;
        }
        .header { text-align: center; border-bottom: 2px dashed #333; padding-bottom: 10px; margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 12px; }
        
        .info { margin-bottom: 10px; font-size: 12px; }
        .info table { width: 100%; }
        .info td { padding: 2px 0; }
        
        .items { border-top: 1px solid #333; border-bottom: 1px solid #333; padding: 10px 0; margin-bottom: 10px; }
        .items table { width: 100%; font-size: 12px; }
        .items th { text-align: left; }
        .items .price { text-align: right; }
        
        .total { text-align: right; font-weight: bold; font-size: 14px; margin-bottom: 20px; }
        
        .footer { text-align: center; font-size: 10px; border-top: 1px dashed #333; padding-top: 10px; }
        
        /* Tombol Print agar tidak ikut tercetak */
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-print {
            background: #333; color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-family: sans-serif;
        }
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print">
        <a href="{{ route('transaksi.index') }}" class="btn-print">&laquo; Kembali</a>
    </div>

    <div class="header">
        <h2>LAUNDRY DESY</h2>
        <p>Jl. Mawar Melati No. 123, Kota Medan</p>
        <p>WA: 0812-3456-7890</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td>No. TRX</td>
                <td>: <strong>{{ $trx->kode_transaksi }}</strong></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $trx->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>: {{ $trx->user->name }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: {{ $trx->status_bayar }}</td>
            </tr>
        </table>
    </div>

    <div class="items">
        <table>
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th class="price">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $trx->paket->nama_paket }}<br>
                        <small>{{ $trx->berat }} Kg x Rp {{ number_format($trx->paket->harga_per_kg) }}</small>
                    </td>
                    <td class="price">
                        Rp {{ number_format($trx->total_harga) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="total">
        TOTAL BAYAR: Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Terima kasih telah mempercayakan cucian Anda kepada kami.</p>
        <p>Harap struk ini dibawa saat pengambilan.</p>
    </div>

</body>
</html>