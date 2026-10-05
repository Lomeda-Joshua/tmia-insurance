<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Mpdf\Mpdf;
use App\Models\TransactionRb; // Adjust model name as needed

class PdfController extends Controller
{
    public function generatePdf($insurance_no)
    {
        // 1. Fetch transaction record along with payment history
        $transaction = TransactionRb::where('Insurance_No', $insurance_no)->firstOrFail();

        // 2. Map transaction properties to match the summary view requirements
        $data = [
            'Insurance_No'      => $transaction->Insurance_No,
            'Customer_No'       => $transaction->Customer_No,
            'Full_Name'         => $transaction->Full_Name,
            'Contact_No'        => $transaction->Contact_No,
            'Trans_Date'        => $transaction->Trans_Date,
            'VIN'               => $transaction->VIN,
            'CS_No'             => $transaction->CS_No,
            'Plate_No'          => $transaction->Plate_No,
            'Model'             => $transaction->Model,
            'Variant'           => $transaction->Variant,
            'Insurance_Company' => $transaction->Insurance_Company,
            'Trans_Status'      => $transaction->Trans_Status,
            'Policy_Expiration' => $transaction->Policy_Expiration,
            'ISE_Name'          => $transaction->ISE_Name,
        ];

        // Retrieve related payments (adjust relationship name if different in your model)
        $payments = $transaction->payments ?? [];

        // 3. Render HTML using your Blade template
        $html = view('livewire.main.pdf.invoice', compact('data', 'payments', 'transaction'))->render();

        // 4. Configure temporary directory to prevent permission/write errors
        $tempDir = storage_path('app/mpdf');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0775, true);
        }

        // 5. Initialize mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'orientation'   => 'P',
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => 10,
            'margin_bottom' => 10,
            'tempDir'       => $tempDir,
        ]);

        $mpdf->WriteHTML($html);

        // 6. Return stream response properly for mPDF
        return response($mpdf->Output("insurance_{$insurance_no}.pdf", \Mpdf\Output\Destination::INLINE))
            ->header('Content-Type', 'application/pdf');
    }

}
