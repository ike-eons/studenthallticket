@extends('layouts.master')

@section('content')
<div class="container-fluid">
    
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <h2>$student->index_no</h2>
        
</div>
@endsection