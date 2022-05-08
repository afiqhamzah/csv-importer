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

class ProcessFileBackgroundJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $product_document;
    private $file_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product_document, $file_path)
    {
	    $this->product_document = $product_document;
	    $this->file_path = $file_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	    $this->product_document->update(['status' => ProductDocument::STATUS_PROCESSING]);

	    
	    try{


	    Excel::queueImport(new ProductsImport($this->product_document->id), Storage::disk('local')->path($this->file_path))
		    ->chain([new UpdateProductDocumentStatusComplete($this->product_document)]);


	    }catch(\Exception $e){

		    logger('failed uploading file document : ');
		    logger(print_r($e, true));
	            $this->product_document->update(['status' => ProductDocument::STATUS_FAILED]);

	    }


    }
}
