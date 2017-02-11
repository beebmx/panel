@section('title', 'Error')
@section('module', 'error')
@extends('panel::layouts.panel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <h3 class="index-title padding">Error {{ $error }}</h3>
    </div>
</div>
@endsection
