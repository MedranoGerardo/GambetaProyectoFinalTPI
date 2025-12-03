<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Pago</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #2c3e50;
            margin: 0;
            padding: 20px 35px;
        }

        .title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            color: #1A7FB8;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        .section-title {
            background: #1A7FB8;
            color: white;
            padding: 8px 10px;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 25px;
            margin-bottom: 0;
        }

        .section-box {
            border: 1px solid #1A7FB8;
            border-top: none;
            padding: 12px 12px;
            border-radius: 0 0 4px 4px;
            background: #f6fbff;
        }

        .row {
            margin-bottom: 8px;
        }

        .label {
            font-weight: bold;
            color: #000;
        }

        .value {
            color: #2c3e50;
        }

        .amount-box {
            background: #27ae60;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 6px;
            margin: 25px 0;
        }

        .amount-big {
            font-size: 26px;
            font-weight: bold;
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 30px;
            color: #7f8c8d;
        }

        .footer strong {
            color: #1A7FB8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .summary-table td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
        }

        .summary-table tr:last-child td {
            border-bottom: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1 class="title">GAMBETA</h1>
    <p class="subtitle">Comprobante de Pago — Nº {{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>

    <!-- CLIENTE -->
    <h3 class="section-title">Información del Cliente</h3>
    <div class="section-box">
        <div class="row"><span class="label">Nombre:</span> <span class="value">{{ $payment->reservation->client->name }}</span></div>
        <div class="row"><span class="label">Teléfono:</span> <span class="value">{{ $payment->reservation->client->phone ?? 'N/A' }}</span></div>
        <div class="row"><span class="label">Equipo / Grupo:</span> <span class="value">{{ $payment->reservation->client->team ?? 'N/A' }}</span></div>
    </div>

    <!-- RESERVA -->
    <h3 class="section-title">Datos de la Reserva</h3>
    <div class="section-box">
        <div class="row"><span class="label">Cancha:</span> <span class="value">{{ $payment->reservation->field->name }}</span></div>
        <div class="row"><span class="label">Fecha:</span> <span class="value">{{ \Carbon\Carbon::parse($payment->reservation->date)->format('d/m/Y') }}</span></div>
        <div class="row"><span class="label">Horario:</span> <span class="value">{{ $payment->reservation->start_time }} - {{ $payment->reservation->end_time }}</span></div>

        @php
            $h1 = \Carbon\Carbon::parse($payment->reservation->start_time);
            $h2 = \Carbon\Carbon::parse($payment->reservation->end_time);
        @endphp

        <div class="row"><span class="label">Duración:</span> 
            <span class="value">{{ $h1->diffInHours($h2) }} horas</span>
        </div>
    </div>

    <!-- MONTO PAGADO -->
    <div class="amount-box">
        <div>Monto pagado:</div>
        <div class="amount-big">${{ number_format($payment->amount, 2) }}</div>

        <div style="font-size: 12px; opacity: 0.9;">
            Método: {{ ucfirst($payment->method) }} <br>
            {{ $payment->is_advance ? '(Pago de Adelanto)' : '(Pago Completo)' }}
        </div>
    </div>

    <!-- RESUMEN -->
    <h3 class="section-title">Resumen Financiero</h3>
    <div class="section-box">
        <table class="summary-table">
            <tr>
                <td>Total de la reserva:</td>
                <td style="text-align:right;">${{ number_format($payment->reservation->total_price, 2) }}</td>
            </tr>
            <tr>
                <td>Monto pagado:</td>
                <td style="text-align:right;">${{ number_format($payment->amount, 2) }}</td>
            </tr>

            @php $restante = $payment->reservation->total_price - $payment->amount; @endphp

            @if ($restante > 0)
                <tr>
                    <td>Saldo pendiente:</td>
                    <td style="text-align:right; color:#e74c3c;">${{ number_format($restante, 2) }}</td>
                </tr>
            @else
                <tr>
                    <td style="color:#27ae60">Estado:</td>
                    <td style="text-align:right; color:#27ae60;">PAGADO COMPLETO</td>
                </tr>
            @endif
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Documento generado automáticamente por <strong>GAMBETA</strong><br>
        Fecha: {{ now()->format('d/m/Y H:i:s') }}
    </div>

</body>
</html>
