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
			      <td class=product_document_status_cell_id_{{ $product_document->id }}>{{  $product_document->statusLabel() }}</td>
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

    myDropzone.on("success", file => {
    	window.location.reload();
    });
};

document.addEventListener("DOMContentLoaded", init_dropzone);

</script>

<script type="text/javascript">

let handle_product_document_status = (message) => {

    let product_documents = JSON.parse(message).data;

    if(! Array.isArray(product_documents) || product_documents.length < 1){
	    return;
    }

    let notify_status_update = (x) => {
     	need_notify = document.querySelector("td.product_document_status_cell_id_"+x.id).innerText != x.status_name;

	if(need_notify){
	    alert(x.file_name + " status changed to " + x.status_name);
	}
    }

    let update_status = (x) => document.querySelector("td.product_document_status_cell_id_"+x.id).innerText = x.status_name;

    let handle = x => {
    	notify_status_update(x);
    	update_status(x);
    }

    product_documents.forEach(x => handle(x));
};

async function subscribe() {
  let response = await fetch( "{{ route('product-document.data') }}" );

  if (response.status == 502) {
    // Status 502 is a connection timeout error,
    // may happen when the connection was pending for too long,
    // and the remote server or a proxy closed it
    // let's reconnect
    await subscribe();
  } else if (response.status != 200) {
    // An error - let's show it
    // alert(response.statusText);
    // Reconnect in one second
    await new Promise(resolve => setTimeout(resolve, 50000));
    await subscribe();
  } else {
    // Get and show the message
    let message = await response.text();
    handle_product_document_status(message);
    // Call subscribe() again to get the next message
    await subscribe();
  }
}

subscribe();

</script>
