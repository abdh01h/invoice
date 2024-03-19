@if($errors->any())
    <div class="alert alert-solid-danger alert-dismissible fade show" role="alert">
        <h3>Error</h3>
        @foreach ($errors->all() as $error)
            <ul>
                <li> {{ $error }}</li>
            </ul>
        @endforeach
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
