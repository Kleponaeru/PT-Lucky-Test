<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MahasiswaExport;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * PRINT (MVC)
     */
    public function index()
    {
        $data = Mahasiswa::with('jenisKelamin')->get();
        // dd($data[0]->m_id);
        return view('report.index', compact('data'));
    }

    /**
     * EXPORT EXCEL
     */
    public function exportExcel()
    {
        return Excel::download(new MahasiswaExport, 'laporan-mahasiswa.xlsx');
    }

    /**
     * SEND EXCEL TO WHATSAPP
     */
    public function sendToWhatsApp()
    {
        try {
            // Step 1: Generate Excel file and save locally
            $fileName = 'laporan-mahasiswa.xlsx';
            Excel::store(new MahasiswaExport, $fileName, 'local');
            $filePath = storage_path('app/' . $fileName);

            // Step 2: Upload file to WhatsApp Cloud API
            $upload = Http::withToken(env('WHATSAPP_TOKEN'))
                ->attach('file', file_get_contents($filePath), $fileName)
                ->post("https://graph.facebook.com/v19.0/" . env('WHATSAPP_PHONE_ID') . "/media");

            if (!isset($upload['id'])) {
                Log::error('WhatsApp Upload Error:', $upload->json());
                return back()->with('error', 'Failed to upload file to WhatsApp API.');
            }

            $mediaId = $upload['id'];

            // Step 3: Send WhatsApp message with document
            $send = Http::withToken(env('WHATSAPP_TOKEN'))
                ->post("https://graph.facebook.com/v19.0/" . env('WHATSAPP_PHONE_ID') . "/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => '6281287765396',  // Number in the test
                    'type' => 'document',
                    'document' => [
                        'id' => $mediaId,
                        'caption' => 'Berikut Laporan Mahasiswa'
                    ]
                ]);

            if (!isset($send['messages'])) {
                Log::error('WhatsApp Send Error:', $send->json());
                return back()->with('error', 'Failed to send WhatsApp message.');
            }

            return back()->with('success', 'Laporan berhasil dikirim via WhatsApp!');

        } catch (\Exception $e) {
            Log::error('WhatsApp Error:', ['message' => $e->getMessage()]);
            return back()->with('error', 'Unexpected error occurred.');
        }
    }
}
