@if (session()->has('type'))
    <div class="alert alert-solid-{{ session()->get('type') }} alert-dismissible fade show" role="alert" id="alert">
        <strong>{{ Session::get('title') }}:</strong> {{ Session::get('message') }}
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
