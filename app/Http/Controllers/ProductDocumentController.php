<?php

namespace App\Http\Controllers;

use App\Models\ProductDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Jobs\UploadFileBackgroundJob;

class ProductDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $product_documents = ProductDocument::all();

	    return view('product_documents.index', ['product_documents' => $product_documents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $rule = [
	            'file' => 'required',
	            'extension' => 'required|in:csv, text, txt',
	    ];

	    $validation = Validator::make([
		    'file' => $request->file(), 
		    'extension' => $request->file('file')->getClientOriginalExtension()
	    ], $rule);

	    if($validation->fails()){
	            return Response::make($validation->errors()->first(), 400);
	    }

	    $file = $request->file('file');
	    $file_name = $file->getClientOriginalName();

	    

	    $product_document = ProductDocument::updateOrCreate([
 	           'file_name' => $file_name
	        ],[
	            'status' => ProductDocument::STATUS_PENDING
                ],
	    );

	    Storage::disk('local')->put('product_documents/' . $request->file('file')->getClientOriginalName(), $request->file('file'));

	    UploadFileBackgroundJob::dispatch($product_document, $request);

	    return Response::json('success', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductDocument  $productDocument
     * @return \Illuminate\Http\Response
     */
    public function show(ProductDocument $productDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductDocument  $productDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductDocument $productDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductDocument  $productDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductDocument $productDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductDocument  $productDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductDocument $productDocument)
    {
        //
    }
}
