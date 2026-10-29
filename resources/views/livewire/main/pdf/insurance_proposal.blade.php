
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
            padding: 10px 20px;
        }
        /* Header */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
            background-color: #f4f6f8;
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
    <div class="proposal-heading">Your Motor Vehicle Insurance Proposal</div>
    <div class="proposal-sub">Clear coverage and premium details for your review.</div>
    
    <div>
        <div class="proposal-desc">
            <div class="greeting" style="margin-bottom: 6px;">Dear {{ $transaction['Full_Name'] ?? '' }},</div>
            Thank you for considering Toyota Insurance Inc. Agency (TMIA). We are pleased to provide this renewal proposal for your motor vehicle insurance needs. The quotation below summarizes the selected coverage and estimated annual premium.
        </div>
        <div class="inception-right">
            Inception date:<br>
            <strong><?php $inception_date = new DateTime($transaction['Start_Date'], new DateTimeZone('Asia/Manila')) 
                                    echo $inception_date->format('M d, Y') ?? '';
                    ?></strong><br>
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
                <div class="info-subvalue">{{ $transaction['Prod_Classify'] ?? '' }} · Plate No. {{ $transaction['Plate_No'] ?? 'To be acquired' }}</div>
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
                <div class="info-value">{{ $transaction['Gross_Premium'] ?? '' }}</div>
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
                <td>₱500,000.00</td>
                <td>₱8,008.45</td>
            </tr>
            <tr>
                <td>Acts of Nature</td>
                <td>₱500,000.00</td>
                <td>₱2,355.43</td>
            </tr>
            <tr>
                <td>VTPL – Bodily Injury</td>
                <td>As per policy</td>
                <td>₱420.00</td>
            </tr>
            <tr>
                <td>VTPL – Property Damage</td>
                <td>As per policy</td>
                <td>₱1,245.00</td>
            </tr>
            <tr>
                <td>Auto Personal Accident</td>
                <td>As per policy</td>
                <td>₱0.00</td>
            </tr>
        </tbody>
    </table>

    <!-- Totals Table -->
    <table class="totals-table">
        <tr>
            <td>Gross premium</td>
            <td>₱12,028.87</td>
        </tr>
        <tr>
            <td>VAT</td>
            <td>₱1,443.46</td>
        </tr>
        <tr>
            <td>Documentary stamp tax</td>
            <td>₱1,503.61</td>
        </tr>
        <tr>
            <td>Local tax</td>
            <td>₱24.06</td>
        </tr>
        <tr class="grand-total-row">
            <td>Total customer payable</td>
            <td>₱15,000.00</td>
        </tr>
    </table>

    <!-- Deductible Note -->
    <div class="deductible-box">
        <strong>Deductible / participation:</strong> ₱3,000.00 per accident or panel, subject to the final policy terms.
    </div>

    <!-- Footer Options & Reminders -->
    <table class="footer-grid">
        <tr>
            <td>
                <div class="footer-box-title">Payment options</div>
                <div class="footer-box-content">
                    <ul>
                        <li>Deposit to authorized Toyota Makati accounts.</li>
                        <li>Deferred payment options may be available, subject to bank or card provider approval.</li>
                    </ul>
                </div>
            </td>
            <td>
                <div class="footer-box-title">Important reminders</div>
                <div class="footer-box-content">
                    <ul>
                        <li>This is an indicative quotation and is subject to underwriting approval.</li>
                    </ul>
                </div>
            </td>
        </tr>
    </table>

    </body>
</html>