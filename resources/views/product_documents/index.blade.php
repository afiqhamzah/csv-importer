@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">


                <div class="card-header">{{ __('Product Documents') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

			<form 
			  id="product_document_form" 
			  class="dropzone" 
                          action="{{ route('product-document.store') }}"
			>
			  @csrf
			</form>

			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">Time</th>
			      <th scope="col">File Name</th>
			      <th scope="col">Status</th>
			    </tr>
			  </thead>
			  <tbody>
			    @foreach($product_documents as $product_document)
			    <tr>
			      <th scope="row">
				{{  $product_document->formatted_created_at }}
				<br>
				{{  $product_document->created_since }}
			     </th>
			      <td>{{  $product_document->file_name }}</td>
			      <td>{{  $product_document->statusLabel() }}</td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">

const init_dropzone = function(){
    let myDropzone = new Dropzone("#product_document_form");

    myDropzone.on("addedfile", file => {
      console.log(`File added: ${file.name}`);
    });
};

document.addEventListener("DOMContentLoaded", init_dropzone);

</script>
