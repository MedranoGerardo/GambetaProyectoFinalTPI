<h2 style="text-align:center; color:#1A7FB8;">Comprobante de Pago</h2>

<hr>

<h3>Datos del Cliente</h3>
<p><strong>Nombre:</strong> {{ $payment->reservation->client->name }}</p>
<p><strong>Teléfono:</strong> {{ $payment->reservation->client->phone ?? 'N/A' }}</p>
<p><strong>Equipo / Grupo:</strong> {{ $payment->reservation->client->team ?? 'N/A' }}</p>

<hr>

<h3>Datos de la Reserva</h3>
<p><strong>Cancha:</strong> {{ $payment->reservation->field->name }}</p>
<p><strong>Fecha:</strong> {{ $payment->reservation->date }}</p>
<p><strong>Horario:</strong> {{ $payment->reservation->start_time }} - {{ $payment->reservation->end_time }}</p>
<p><strong>Total de la reserva:</strong> ${{ $payment->reservation->total_price }}</p>

<hr>

<h3>Pago Registrado</h3>
<ul>
    <li><strong>Monto:</strong> ${{ number_format($payment->amount, 2) }}</li>
    <li><strong>Método:</strong> {{ ucfirst($payment->method) }}</li>
    <li><strong>Tipo:</strong> {{ $payment->is_advance ? 'Adelanto' : 'Pago completo' }}</li>
    <li><strong>Fecha:</strong> {{ $payment->created_at->format('d/m/Y H:i') }}</li>
</ul>

<hr>

<p style="text-align:center; font-size:12px; color:#666;">
    Documento generado automáticamente por el sistema <strong>Gambeta</strong><br>
    {{ now()->format('d/m/Y H:i') }}
</p>
