<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentPDFController extends Controller
{
    public function generate($id)
    {
        // Obtener solamente el pago actual
        $payment = Payment::with([
            'reservation.client',
            'reservation.field'
        ])->findOrFail($id);

        // Generar PDF
        $pdf = Pdf::loadView('pdf.payment', compact('payment'));

        return $pdf->download('comprobante_pago_'.$id.'.pdf');
    }
}
