<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Barang</title>
</head>

<body style="margin:0;padding:0;background:#f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:8px;overflow:hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="padding:20px 30px 10px 30px;">
                            <table width="100%">
                                <tr>
                                    <td align="center" style="font-size:24px;font-weight:bold;color:#333;">
                                        Laporan Stok Barang
                                    </td>
                                    <td align="right" width="80">
                                        <img src="{{ $message->embed(public_path('assets/images/logo/sinarmeadow.png')) }}" alt="Logo Sinar Meadow" width="60" style="display:block;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Garis bawah header -->
                    <tr>
                        <td style="border-bottom:1px solid #e0e0e0;"></td>
                    </tr>
                    <!-- Isi Email -->
                    <tr>
                        <td style="padding:30px 30px 20px 30px; color:#333; font-size:16px;">
                            <p>Yth. Bapak/Ibu {{ $user->name}},</p>
                            <p>Berikut kami lampirkan laporan stok barang terbaru dalam bentuk file Excel, pertanggal {{ now()->format('d-m-Y') }}</p>
                            <p>Silakan unduh attachment pada email ini untuk melihat detail laporan.</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="border-bottom:1px solid #e0e0e0;"></td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px 30px 10px 30px;">
                            <table width="100%">
                                <tr>
                                    <td align="center" style="font-size:13px;color:#888; padding: 0 30px 10px 30px;">
                                        &copy; {{ date('Y') }} PT. Sinar Meadow International Indonesia. All rights reserved.<br>
                                        <span style="display:inline-block; padding:10px 20px; background:#f4f4f4; border-radius:6px; margin-top:8px;">
                                            Kawasan Industri Pulogadung, Jl. Pulo Ayang, Jatinegara, Kec. Cakung,<br>Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta
                                        </span><br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="10"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>