<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Konfirmasi Reservasi Kosify</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 24px; }
        .card { max-width: 560px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; }
        .header { background: #0f172a; color: #ffffff; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 800; letter-spacing: 0.5px; }
        .header p { margin: 4px 0 0; font-size: 12px; color: #94a3b8; }
        .content { padding: 28px; }
        .badge-success { display: inline-block; background: #dcfce7; color: #15803d; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 6px; border: 1px solid #bbf7d0; text-transform: uppercase; }
        .details-table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .details-table td { padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .details-table td.label { color: #64748b; font-weight: 500; }
        .details-table td.val { text-align: right; font-weight: 700; color: #0f172a; }
        .btn { display: inline-block; background: #0f172a; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 10px; font-weight: 700; font-size: 12px; text-transform: uppercase; margin-top: 10px; }
        .footer { padding: 20px; text-align: center; font-size: 11px; color: #94a3b8; background: #f8fafc; border-top: 1px solid #f1f5f9; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>KOSIFY</h1>
            <p>Konfirmasi Pembayaran & Sewa Kamar</p>
        </div>
        <div class="content">
            <p style="font-size: 14px; margin-top: 0;">Halo, <strong>{{ $reservation->user->name ?? 'Penyewa' }}</strong>!</p>
            <p style="font-size: 13px; color: #475569; line-height: 1.6;">
                Terima kasih! Pembayaran Anda telah kami terima dan reservasi kamar kos Anda telah <span class="badge-success">Lunas / Berhasil</span>.
            </p>

            <table class="details-table">
                <tr>
                    <td class="label">Nomor Kamar</td>
                    <td class="val">Kamar {{ $reservation->room->room_number ?? '-' }} ({{ $reservation->room->room_type ?? 'Standard' }})</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Masuk (Check-in)</td>
                    <td class="val">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Durasi Sewa</td>
                    <td class="val">{{ $reservation->duration_months ?: 1 }} Bulan</td>
                </tr>
                <tr>
                    <td class="label">Total Pembayaran</td>
                    <td class="val" style="color: #0f172a; font-size: 15px;">Rp {{ number_format(($reservation->room->price_per_month ?? 0) * ($reservation->duration_months ?: 1), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">Status Reservasi</td>
                    <td class="val"><span class="badge-success">LUNAS</span></td>
                </tr>
            </table>

            <div style="text-align: center; margin: 24px 0 10px;">
                <a href="{{ url('/my-bookings') }}" class="btn" style="color:#ffffff;">Buka Portal Penyewa &rarr;</a>
            </div>

            <p style="font-size: 12px; color: #64748b; line-height: 1.5; text-align: center; margin-top: 16px;">
                Anda dapat mengunduh <strong>Surat Perjanjian Sewa (Kontrak PDF)</strong> dan <strong>Kuitansi Resmi (Invoice PDF)</strong> secara langsung di portal akun Anda.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Kosify Platform. All rights reserved.<br>
            Jl. Kosify Raya No. 88, Pusat Kota
        </div>
    </div>
</body>
</html>
