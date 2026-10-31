
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Renewal Business | Policy Summary - {{ $data['Insurance_No'] ?? '' }}</title>
    
        <style>
        /* A4 Page setup for printing/PDF engines */
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .quotation-container {
            width: 100%;
            max-width: 100%; /* Stretches fully across the A4 width */
            margin: 0 auto;
            background: #fff;
            box-sizing: border-box;
        }
        /* Header */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .header-table td {
            vertical-align: top;
        }
        .quotation-title {
            font-size: 13px;
            color: #666;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .meta-box {
            text-align: right;
        }
        .quotation-no {
            font-size: 16px;
            font-weight: bold;
            color: #111;
        }
        .meta-text {
            font-size: 11px;
            color: #666;
        }
        .badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 3px;
            margin-top: 5px;
            border: 1px solid #ffeeba;
        }
        
        /* Intro Section */
        .proposal-heading {
            font-size: 18px;
            font-weight: bold;
            color: #222;
            margin-bottom: 5px;
        }
        .proposal-sub {
            font-size: 12px;
            color: #666;
            margin-bottom: 15px;
        }
        .greeting {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .proposal-desc {
            font-size: 12px;
            color: #441;
            line-height: 1.5;
            margin-bottom: 20px;
            width: 65%;
            float: left;
        }
        .inception-right {
            float: right;
            text-align: right;
            font-size: 11px;
            color: #555;
        }

        /* Info Grid Boxes */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .info-grid td {
            width: 50%;
            background: #f4f6f8;
            padding: 12px 18px;
            vertical-align: top;
            border: 6px solid #fff; /* creates visual padding/spacing between grid items */
        }
        .info-label {
            font-size: 10px;
            font-weight: bold;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 13px;
            font-weight: bold;
            color: #222;
        }
        .info-subvalue {
            font-size: 11px;
            color: #555;
            margin-top: 2px;
        }

        /* Section Title */
        .section-heading {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        /* Summary Table */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .summary-table th {
            background-color: #1a253a;
            color: #fff;
            font-size: 11px;
            text-transform: uppercase;
            padding: 9px 12px;
            text-align: left;
            letter-spacing: 0.5px;
        }
        .summary-table th:nth-child(2),
        .summary-table th:nth-child(3) {
            text-align: right;
        }
        .summary-table td {
            padding: 9px 12px;
            font-size: 12px;
            border-bottom: 1px solid #e5e5e5;
            color: #333;
        }
        .summary-table td:nth-child(2),
        .summary-table td:nth-child(3) {
            text-align: right;
        }
        
        /* Totals section */
        .totals-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .totals-table td {
            padding: 5px 12px;
            font-size: 12px;
        }
        .totals-table td:first-child {
            text-align: right;
            color: #555;
        }
        .totals-table td:last-child {
            text-align: right;
            font-weight: bold;
            width: 180px;
            color: #222;
        }
        .grand-total-row td {
            border-top: 2px solid #ccc;
            border-bottom: 2px solid #ccc;
            padding: 9px 12px !important;
            font-size: 13px !important;
            font-weight: bold;
            color: #000;
        }

        /* Footer Notes */
        .deductible-box {
            background-color: #d9ff00;
            padding: 10px 14px;
            font-size: 11px;
            color: #555;
            margin-bottom: 25px;
            border-left: 3px solid #1a253a;
        }
        .footer-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-grid td {
            width: 50%;
            vertical-align: top;
            padding: 0 15px;
        }
        .footer-grid td:first-child {
            padding-left: 0;
        }
        .footer-grid td:last-child {
            padding-right: 0;
        }
        .footer-box-title {
            font-size: 11px;
            font-weight: bold;
            color: #333;
            margin-bottom: 6px;
        }
        .footer-box-content {
            font-size: 10px;
            color: #666;
            line-height: 1.4;
        }
        .footer-box-content ul {
            margin: 0;
            padding-left: 15px;
            list-style-type:none;
        }
    </style>

    <div class="quotation-container">

    
    <!-- Top Header -->
    <table class="header-table">
        <tr>
            <td style="width: 60%;">
                <div style="font-size: 15px; font-weight: bold; text-transform:uppercase; color: #111;">Toyota Makati Inc. Agency</div>
                <div class="quotation-title" style="margin-top: 4px;">Motor Vehicle Insurance Quotation</div>
            </td>
            <td class="meta-box" style="width: 40%;">
                <div class="quotation-no">{{ $transaction['Insurance_No'] ?? '' }}</div>
                <div class="meta-text">Prepared by <span >{{ $transaction['ISE_Name'] ?? '' }}</span></div>

                @php
                    $dateTime = new DateTime('now', new DateTimeZone('Asia/Manila'));
                @endphp

                <div class="meta-text">Prepared on {{ $dateTime->format('M d, Y'); }}</div>
                <div><span class="badge">Renewal</span></div>
            </td>
        </tr>
    </table>                                                        

    <!-- Proposal Intro -->
    <div class="proposal-heading">Your vehicle protection notice</div>
    <div class="proposal-sub"><i>"Solutions for you and your car"</i></div>
    
    <div>
        <div class="proposal-desc">
            <div class="greeting" style="margin-bottom: 6px;">Dear {{ $transaction['Full_Name'] ?? '' }},</div>
            Thank you for considering Toyota Makati Inc. Agency, We are pleased to present this renewal proposal for your upcoming insurance policy. The details below summarize your selected coverage options and annual premium to ensure optimal protection for your requirements.
        </div>
        <div class="inception-right">
            Inception date:<br>
            <strong></strong><br>
            <span style="font-size: 10px; color: #777;">Valid until {{ $transaction['Policy_Expiration'] ?? ''  }}</span>
        </div>
    </div>

    <div style="clear: both; margin-bottom: 15px;"></div>

    <!-- Info Grid Block -->
    <table class="info-grid">
        <tr>
            <td>
                <div class="info-label">Insured Customer</div>
                <div class="info-value">{{ $transaction['Full_Name'] ?? '' }}</div>
                <div class="info-subvalue">{{ $transaction['Contact_No'] ?? '' }}</div>
            </td>
            <td>
                <div class="info-label">Vehicle</div>
                <div class="info-value">{{ $transaction['Variant'] ?? '' }}</div>
                <div class="info-subvalue">
                    {{ match((int) ($transaction['Prod_Classify'] ?? 0)) {
                                1 => 'Individual',
                                2 => 'Government',
                                3 => 'Fleet',
                                4 => 'Corporate',
                                default => '',
                            } }} | Plate No. {{ $transaction['Plate_No'] ?? 'To be acquired' }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="info-label">Insurance Partner</div>
                <div class="info-value">{{ $transaction['Insurance_Company'] ?? '' }}</div>
                <div class="info-subvalue">Motor Vehicle Insurance</div>
            </td>
            <td>
                <div class="info-label">Sum Insured</div>
                <div class="info-value">Php {{ $transaction['Gross_Premium'] ?? '' }}</div>
                <div class="info-subvalue">Subject to insurer review and acceptance</div>
            </td>
        </tr>
    </table>

    <!-- Coverage and Premium Summary -->
    <div class="section-heading">Coverage and Premium Summary</div>
    
    <table class="summary-table">
        <thead>
            <tr>
                <th style="width: 50%;">Coverage</th>
                <th style="width: 25%;">Sum Insured / Limit</th>
                <th style="width: 25%;">Customer Premium</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Own Damage / Theft</td>
                <td>Php 500,000.00</td>
                <td>Php 8,008.45</td>
            </tr>
            <tr>
                <td>Acts of Nature</td>
                <td>Php 500,000.00</td>
                <td>Php 2,355.43</td>
            </tr>
            <tr>
                <td>VTPL – Bodily Injury</td>
                <td>As per policy</td>
                <td>Php 420.00</td>
            </tr>
            <tr>
                <td>VTPL – Property Damage</td>
                <td>As per policy</td>
                <td>Php 1,245.00</td>
            </tr>
            <tr>
                <td>Auto Personal Accident</td>
                <td>As per policy</td>
                <td>Php 0.00</td>
            </tr>
        </tbody>
    </table>

    <!-- Totals Table -->
    <table class="totals-table">
        <tr>
            <td>Gross premium</td>
            <td>Php 12,028.87</td>
        </tr>
        <tr>
            <td>VAT</td>
            <td>Php 1,443.46</td>
        </tr>
        <tr>
            <td>Documentary stamp tax</td>
            <td>1,503.61</td>
        </tr>
        <tr>
            <td>Local tax</td>
            <td>Php 24.06</td>
        </tr>
        <tr class="grand-total-row">
            <td>Total Premium (inclusive of taxes)</td>
            <td>Php 15,000.00</td>
        </tr>
    </table>

    <!-- Deductible Note -->
    <div class="deductible-box">
        <strong>Deductible / participation:</strong>Php 2,000 per accident/panel.
    </div>

    <!-- Footer Options & Reminders -->
    <table class="footer-grid">
        <tr>
            <td>
                <div class="footer-box-title">You may avail of the following payment options:</div>
                <div class="footer-box-content">
                    <ul>
                        <li>1. Deposit to the following accounts:</li>
                        <li>METROBANK SA#066-3-06666727-9 /  BPI CA#4831-0014-75/ BDO SA#005330027420</li>
                        <li>2. 0% Deferred Payments (applicable to METROBANK, BPI OR BDO CREDIT CARD HOLDERS)</li>
                    </ul>
                </div>
            </td>
            <td>
                <div class="footer-box-title">For further inquiries, feel free to call our Insurance Sales Executive at the following numbers:</div>
                <div class="footer-box-content">
                    <ul>
                        <li>Trunkline: 8897-3333 Local 230 (Ferl) 229 (Kim) 235 (Angie)</li>
                        <li>CEL #: 0995-1564945/0917-5401743 (Ferl) 0916-2298017 (Kim) 0967-0499665 (Angie) ALL VIBER READY</li>
                    </ul>
                </div>
            </td>
        </tr>
    </table>

    </body>
</html>