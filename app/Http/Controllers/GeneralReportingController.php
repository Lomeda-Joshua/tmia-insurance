<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;


class GeneralReportingController extends Controller
{
    public function index(){
        return view('livewire.main.report.newbusiness_renewal_report');
    }

    public function show(){
        
    }

    public function insuranceQuotation(){
        return view('livewire.main.pdf.insurance_proposal');
    }



    public function detailedExcel(Request $request): StreamedResponse
    {
        $request->validate([
            'bustype'    => 'nullable|string|max:50',
            'transtatus' => 'nullable|string|max:50',
            'datefrom'   => 'nullable|string|max:30',
            'dateto'     => 'nullable|string|max:30',
        ]);
 
        $bustype    = strtoupper((string) $request->input('bustype', ''));
        $transtatus = (string) $request->input('transtatus', '');
 
        /* ---------------- DATE FILTER ---------------- */
        $from = null;          // inclusive
        $toExclusive = null;   // exclusive (dateto + 1 day)
        $toDisplay = null;
 
        if ($request->filled('datefrom') && $request->filled('dateto')) {
            $from        = Carbon::parse($request->input('datefrom'))->startOfDay();
            $toDisplay   = Carbon::parse($request->input('dateto'))->startOfDay();
            $toExclusive = $toDisplay->copy()->addDay();
        }
 
        /* ---------------- QUERY BUILD ---------------- */
        $applyFilters = function ($query) use ($transtatus, $from, $toExclusive) {
            if ($transtatus !== '' && strtoupper($transtatus) !== 'ALL') {
                $query->where('Trans_Status', $transtatus);
            }
            if ($from && $toExclusive) {
                $query->where('Trans_Date', '>=', $from->format('Y-m-d'))
                      ->where('Trans_Date', '<', $toExclusive->format('Y-m-d'));
            }
            return $query;
        };
 
        $nb = $applyFilters(DB::table('vw_transactions_nb'));
        $rb = $applyFilters(DB::table('vw_transactions_rb'));
 
        $query = match ($bustype) {
            'RENEWAL BUSINESS' => $rb,
            'ALL'              => $nb->unionAll($rb),
            default            => $nb, // NEW BUSINESS or empty
        };
 
        /* ---------------- REPORT SUBTITLE ---------------- */
        if ($from && $toDisplay) {
            $dateInfo = $from->isSameDay($toDisplay)
                ? 'Report as of ' . $from->format('F d, Y')
                : 'Report from ' . $from->format('F d, Y') . ' to ' . $toDisplay->format('F d, Y');
        } else {
            $dateInfo = 'Report generated ' . now()->format('F d, Y');
        }
 
        $filename = 'TMIA_Detailed_Report_' . now()->format('Ymd_His') . '.xlsx';
 
        return response()->streamDownload(function () use ($query, $dateInfo) {
            ini_set('memory_limit', '1024M');
            set_time_limit(0);
 
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Detailed Report');
 
            $currencyCols = ['SRP', 'Gross_Premium', 'Net_Rem', 'Commission', 'Month_Pay'];
 
            $headerRow = 5;
            $rowIndex  = $headerRow;
            $counter   = 0;
            $lastColIndex = 2;
            $headerWritten = false;
 
            /* cursor() streams rows one by one instead of loading them all */
            foreach ($query->cursor() as $record) {
                $row = (array) $record;
 
                if (! $headerWritten) {
                    $sheet->setCellValue('A' . $headerRow, 'No');
                    $colIndex = 2;
                    foreach (array_keys($row) as $col) {
                        $sheet->setCellValue(
                            Coordinate::stringFromColumnIndex($colIndex) . $headerRow,
                            ucwords(str_replace('_', ' ', $col))
                        );
                        $colIndex++;
                    }
                    $lastColIndex = $colIndex - 1;
                    $sheet->getStyle('A' . $headerRow . ':' . Coordinate::stringFromColumnIndex($lastColIndex) . $headerRow)
                          ->getFont()->setBold(true);
                    $headerWritten = true;
                    $rowIndex++;
                }
 
                /* ---- data row ---- */
                $counter++;
                $sheet->setCellValue('A' . $rowIndex, $counter);
 
                $colIndex = 2;
                foreach ($row as $col => $val) {
                    $cell = Coordinate::stringFromColumnIndex($colIndex) . $rowIndex;
 
                    if ($col === 'Trans_Date' && ! empty($val)) {
                        $sheet->setCellValue($cell, ExcelDate::PHPToExcel(strtotime($val)));
                        $sheet->getStyle($cell)->getNumberFormat()
                              ->setFormatCode('yyyy-mm-dd hh:mm:ss');
                    } elseif (in_array($col, $currencyCols, true) && is_numeric($val)) {
                        $sheet->setCellValue($cell, (float) $val);
                        $sheet->getStyle($cell)->getNumberFormat()
                              ->setFormatCode('#,##0.00;[Red]-#,##0.00');
                    } else {
                        $sheet->setCellValue($cell, $val);
                    }
                    $colIndex++;
                }
                $rowIndex++;
            }
 
            if (! $headerWritten) {
                $sheet->setCellValue('A' . $headerRow, 'No records found.');
            }
 
            /* ---- title block (merged across the actual column count) ---- */
            $lastCol = Coordinate::stringFromColumnIndex($lastColIndex);
 
            $sheet->mergeCells("A1:{$lastCol}1");
            $sheet->setCellValue('A1', 'TMI INSURANCE AGENCY INC.');
            $sheet->mergeCells("A2:{$lastCol}2");
            $sheet->setCellValue('A2', 'Detailed Insurance Transaction Report');
            $sheet->mergeCells("A3:{$lastCol}3");
            $sheet->setCellValue('A3', $dateInfo);
 
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(11);
            $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
 
            /* ---- freeze panes & auto size ---- */
            $sheet->freezePane('A6');
            for ($i = 1; $i <= $lastColIndex; $i++) {
                $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
            }
 
            (new Xlsx($spreadsheet))->save('php://output');
 
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        }, $filename, [
            'Content-Type'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }


}
