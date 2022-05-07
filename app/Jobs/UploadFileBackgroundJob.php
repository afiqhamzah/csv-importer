<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ProductDocument;
use Illuminate\Support\Facades\Storage;

class UploadFileBackgroundJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $product_document;

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
	    $this->product_document->update(['status' => ProductDocument::STATUS_PROCESSING]);

	    
	    try{
		   //  Storage::disk('local')->put('product_documents/' . $this->request->file('file')->getClientOriginalName(), $this->request->file('file'));

	    }catch(\Exception $e){

		    logger('failed uploading file document : ');
		    logger(print_r($this->product_document, true));
		    logger(print_r($e, true));
	            $this->product_document->update(['status' => ProductDocument::STATUS_FAILED]);

	    }


	    $this->product_document->update(['status' => ProductDocument::STATUS_COMPLETED]);
    }
}
