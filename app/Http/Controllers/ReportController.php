<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MahasiswaExport;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{

    //  PRINT (MVC)

    public function index()
    {
        $data = Mahasiswa::with('jenisKelamin')->get();
        // dd($data[0]->m_id);
        return view('report.index', compact('data'));
    }

    // EXPORT EXCEL
    public function exportExcel()
    {
        return Excel::download(new MahasiswaExport, 'laporan-mahasiswa.xlsx');
    }

    // SEND EXCEL TO WHATSAPP
    public function sendToWhatsApp()
    {
        try {
            Log::info("=== SEND WHATSAPP STARTED ===");

            // 1. Generate Excel file & save
            $fileName = 'laporan-mahasiswa.xlsx';
            Excel::store(new MahasiswaExport, $fileName, 'local');
            $filePath = storage_path("app/{$fileName}");

            Log::info("Excel created", [
                'path' => $filePath,
                'exists' => file_exists($filePath)
            ]);

            // 2. Upload file to public storage (to get URL)
            Storage::put("public/{$fileName}", file_get_contents($filePath));

            $fileUrl = "https://41a6bfba9763.ngrok-free.app/storage/{$fileName}";

            Log::info("File copied to public", [
                'public_url' => $fileUrl,
                'public_exists' => Storage::exists("public/{$fileName}")
            ]);

            // 3. UltraMsg request (same as their CURL example)
            $params = [
                'token' => env('WHATSAPP_TOKEN'),
                // 'to' => '6289603180657',
                'to' => '6281287765396',
                'filename' => $fileName,
                'document' => base64_encode(file_get_contents($filePath)), // Send as base64
                'caption' => 'Laporan Mahasiswa',
            ];

            $url = "https://api.ultramsg.com/" . env('WHATSAPP_INSTANCE_ID') . "/messages/document";

            Log::info("Sending request to UltraMsg", [
                'url' => $url,
                'params' => $params
            ]);

            // EXACT cURL version → application/x-www-form-urlencoded
            $response = Http::asForm()->post($url, $params);
            $json = $response->json();

            Log::info("UltraMsg Response Parsed", [
                'response' => $json
            ]);

            if (!isset($json['sent']) || $json['sent'] != true) {
                Log::warning("UltraMsg reported failure", [
                    'response' => $json
                ]);

                return back()->with('error', 'Failed to send WhatsApp message.');
            }

            Log::info("=== WHATSAPP SEND SUCCESS ===");

            return back()->with('success', 'Laporan berhasil dikirim via WhatsApp!');

        } catch (\Exception $e) {
            Log::error("UltraMsg Exception", [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return back()->with('error', 'Unexpected error occurred.');
        }
    }
}
