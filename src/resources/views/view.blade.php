@section('title', 'Formulario para captura de '.strtolower($model->name))
@section('module', 'view')
@extends('panel::layouts.panel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <h3 class="index-title padding">{{ $model->name }}</h3>
    </div>
</div>
<div class="container-fluid panel-container bg-gray">
    <div class="panel-body">
    @foreach($fields as $id => $field)
    {!! $field !!}
    @endforeach
    </div>
    @if ($model->files)
    <div class="panel-files col-xs-12">
		<div id="beebmx-panel-files">
    		<div class="panel-body">
        		<div class="label view">Archivos</div>
    			<div class="table-files-container">
    			<table class="table table-hover">
    			<thead>
    				<tr>
    					<th></th>
    					<th>Archivo</th>
    					<th class="hidden-xs">Tamaño</th>
    				</tr>
    			</thead>
    			<tbody>
    				@if ($files)
    				@foreach ($files as $file)
    				<tr data-uri="{{ $file->url() }}" data-basename="{{ $file->basename() }}" data-mime="{{ $file->mime() }}" data-remote="true">
    					<td>
        					@if($file->thumb())
        					<span class="file-viewer"><img src="{{ $file->thumb() }}" /></span>
            				@else
            				<span class="file-icon"><i class="material-icons">insert_drive_file</i></span>
            				@endif
                        </td>
    					<td>{{ $file->basename() }}</td>
    					<td class="hidden-xs">{{ $file->size() }}</td>
    				</tr>
    				@endforeach
    				@endif
    			</tbody>
    			</table>
    			</div>
    		</div>
		</div>
    </div>
    @endif
</div>
@foreach($modals as $id => $modal)
{!! $modal !!}
@endforeach
@endsection

@section('js')
<script>
$(document).ready(function() {
    Structure.view();
});
</script>
@endsection