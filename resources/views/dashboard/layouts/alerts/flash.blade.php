@if (session()->has('message'))
<div class="alert alert-{{session()->get('alert-type')}} " role="alert" id="alert-message">
    <div class="alert-body">
        {{session()->get('message')}}
    </div>

    {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button> --}}
</div>
@endif


