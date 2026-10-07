<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;
use App\Models\Scratchcard;
use Illuminate\Support\Facades\Storage;



class GenerateScratchcardPdfZip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $zipFileName;

    public function __construct()
    {
        $this->zipFileName = storage_path('app/scratchcards_batches.zip');
    }

    public function handle()
    {
        $tmpFolder = storage_path('app/temp_pdfs');
        if (!file_exists($tmpFolder)) mkdir($tmpFolder, 0777, true);

        // Clear old PDFs
        $files = glob($tmpFolder.'/*.pdf');
        foreach ($files as $file) unlink($file);

        $pdfFiles = [];

        // Chunk scratchcards to avoid memory issues
        Scratchcard::orderBy('batch_no')
            ->chunk(5000, function($cards) use (&$pdfFiles, $tmpFolder){
                $batches = $cards->groupBy('batch_no');

                foreach($batches as $batchNo => $batchCards){
                    $fileName = $tmpFolder."/batch_{$batchNo}.pdf";
                    $pdf = Pdf::loadView('export_all', ['allBatches' => [$batchNo => $batchCards]]);
                    $pdf->save($fileName);
                    $pdfFiles[] = $fileName;
                }
            });

        // Create ZIP
        $zip = new ZipArchive;
        if ($zip->open($this->zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach($pdfFiles as $file){
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }

        // Optional: cleanup temp PDFs
        foreach ($pdfFiles as $file) unlink($file);
    }
}
