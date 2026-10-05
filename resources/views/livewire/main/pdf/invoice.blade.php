<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Renewal Business | Policy Summary - {{ $data['Insurance_No'] ?? '' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #222222;
            font-size: 8px;
            line-height: 1.1;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .section-title {
            background-color: #040505;
            color: #ffffff;
            padding: 3px 6px;
            font-weight: bold;
            font-size: 8.5px;
            margin-top: 8px;
            margin-bottom: 4px;
        }
        .section-title-sub {
            color: #040505;
            padding: 3px 6px;
            font-weight: bold;
            font-size: 8.5px;
            margin-top: 8px;
            margin-bottom: 4px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .data-table th {
            background-color: #f2f2f2;
            border: 0.5px solid #cccccc;
            padding: 3px 5px;
            text-align: left;
            font-size: 8px;
        }
        .data-table td {
            border: 0.5px solid #cccccc;
            padding: 3px 5px;
            font-size: 8px;
        }
        .data-table th.col-25 { width: 25%; }
        .data-table td.col-25 { width: 25%; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <!-- Scaled Header Logos -->
    <table class="header-table">
        <tr>
            <td style="text-align: left; width: 60%;">
                <img src="{{ public_path('tmia-assets/images/logo.png') }}" style="width: 120px;">
            </td>
            <td style="text-align: right; width: 40%;">
                <img src="{{ public_path('tmia-assets/images/toyota logo.png') }}" style="width: 50px;">
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-bottom: 8px;">
        <h3 style="margin: 0; padding: 0; font-size: 11px;">RENEWAL BUSINESS</h3>
        <h3 style="margin: 0; padding: 0; font-size: 11px;">INSURANCE POLICY & PAYMENT SUMMARY</h3>
        <span style="font-size: 7.5px; color: #555555;">Transaction Reference: {{ $data['Insurance_No'] ?? 'N/A' }}</span>
    </div>

    <!-- Customer Information -->
    <div class="section-title">CUSTOMER INFORMATION</div>
    <table class="data-table">
            <tr>
                <th class="col-25">Customer No:</th>
                <td class="col-25">{{ $customer_info->Customer_No ?? 'N/A' }}</td>
                <th class="col-25">Full Name:</th>
                <td class="col-25">{{ $customer_info->Full_Name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="col-25">Contact No:</th>
                <td class="col-25">{{ $customer_info->Contact_No ?? 'N/A' }}</td>
                <th class="col-25">Transaction Date:</th>
                <td class="col-25">{{ $transaction->Trans_Date ?? 'N/A' }}</td>
            </tr>
    </table>

    <!-- Vehicle Details -->
    <div class="section-title">VEHICLE DETAILS</div>
    <table class="data-table">
        <tr>
            <th class="col-25">VIN:</th>
            <td class="col-25">{{ $transaction->VIN ?? 'N/A' }}</td>
            <th class="col-25">CS No:</th>
            <td class="col-25">{{ $transaction->CS_No ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th class="col-25">Plate No:</th>
            <td class="col-25">{{ $transaction->Plate_No ?? 'N/A' }}</td>
            <th class="col-25">Model / Variant:</th>
            <td class="col-25">{{ trim(($transaction->Model ?? '') . ' ' . ($transaction->Variant ?? '')) ?: 'N/A' }}</td>
        </tr>
    </table>

    <!-- Policy & Staff Details -->
    <div class="section-title">POLICY DETAILS</div>
    <table class="data-table">
        <tr>
            <th class="col-25">Insurance Company:</th>
            <td class="col-25">{{ $transaction->Insurance_Company ?? 'N/A' }}</td>
            <th class="col-25">Status:</th>
            <td class="col-25">{{ $transaction->Trans_Status ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th class="col-25">Expiration Date:</th>
            <td class="col-25">{{ $transaction->Policy_Expiration ?? 'N/A' }}</td>
            <th class="col-25">Staff (ISE):</th>
            <td class="col-25">{{ $insurance_agent->ISE_Name ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Payment History -->
    <div class="section-title-sub">PAYMENT HISTORY</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25%; text-align: center;">Payment Date</th>
                <th style="width: 25%; text-align: center;">Payment Mode</th>
                <th style="width: 25%; text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments ?? [] as $payment)
                <tr>
                    <td class="text-center">{{ $payment->Payment_Date ?? $payment['Payment_Date'] ?? 'N/A' }}</td>
                    <td class="text-center">{{ $payment->Payment_Type ?? $payment['Payment_Type'] ?? $payment->Payment_Mode ?? 'N/A' }}</td>
                    <td class="text-right">{{ number_format($payment->Payment_Amount ?? $payment['Payment_Amount'] ?? $payment->Amount ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="color: #777777;">No payment records found.</td>
                </tr>
            @endforelse
            
        </tbody>
    </table>
    <br>
    <p style="font-size: 11px; font-weight: 800; text-align: center; margin-top: 10px; margin-bottom: 10px;">
    - - - - - Nothing follows - - - - -
    </p>

</body>
</html>