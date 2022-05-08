<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ProductDocument;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Storage;

class UpdateProductDocumentStatusComplete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $product_document;
    private $file_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product_document)
    {
	    $this->product_document = $product_document;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	    $this->product_document->update(['status' => ProductDocument::STATUS_COMPLETED]);

    }
}
