@section('title', __('panel::form.title', ['title' => strtolower($model->name)]))
@section('module', 'form')
@extends('panel::layouts.panel')

@section('css')

@foreach($resource_css as $r_css)
<link rel="stylesheet" href="{{ asset($r_css) }}">
@endforeach

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <h3 class="index-title padding">{{ $model->name }}</h3>
    </div>
</div>
<div class="container-fluid panel-container bg-gray">
    @if ($method !== 'put')
        @if ($parent === null)
    <form class="panel-form" action="{{ url(config('panel.prefix').'/page/'.$model->url) }}" method="POST" autocomplete="off">
        @else
    <form class="panel-form" action="{{ url(config('panel.prefix').'/page/'.$parent.'/'.$parent_id.'/'.$model->url) }}" method="POST" autocomplete="off">
        @endif
    @else
        @if ($parent === null)
    <form class="panel-form" action="{{ url(config('panel.prefix').'/page/'.$model->url.'/'.$model->getId()) }}" method="POST" autocomplete="off">
        @else
    <form class="panel-form" action="{{ url(config('panel.prefix').'/page/'.$parent.'/'.$parent_id.'/'.$model->url.'/'.$model->getId()) }}" method="POST" autocomplete="off">
        @endif
    @endif
        {{ csrf_field() }}
        @if ($method === 'put')
        {{ method_field('PUT') }}
        @endif
        @foreach($fields as $id => $field)
        {!! $field !!}
        @endforeach
        @if ($model->files)
        <input type="hidden" id="beebmx_panel_files_uploaded" name="files" value="[]" />
        @endif
        <div class="panel-form-submit text-center">
            <button class="btn btn-primary">@lang('panel::form.save')</button>
        </div>
    </form>
    @if ($model->files)
    <div class="panel-files col-xs-12">
		<div>
			<div class="panel-body">
				<div class="btn btn-o btn-success fileinput-button">
    				<i class="ti-plus"></i> <span>@lang('panel::form.add-files')</span>
    				<form>
    					{!! csrf_field() !!}
    					<input type="hidden" name="model" value="{{ $model->url }}" />
    					<input type="hidden" name="id" value="{{ $model->getId() }}" />
    					<input type="file" id="beebmx-panel-fileupload" name="file" data-url="{{ url(config('panel.prefix').'/file/upload') }}" multiple />
    				</form>
				</div>
				
				<div id="beebmx-panel-files">
    				<div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <div class="table-files-container">
					<table class="table table-hover">
					<thead>
						<tr>
							<th></th>
							<th>@lang('panel::form.file')</th>
							<th class="hidden-xs">@lang('panel::form.size')</th>
							<th>@lang('panel::form.delete')</th>
						</tr>
					</thead>
					<tbody>
    					@if ($files)
						@foreach ($files as $file)
						<tr data-uri="{{ url($file->url()) }}" data-basename="{{ $file->basename() }}" data-mime="{{ $file->mime() }}" data-remote="true">
							<td></td>
							<td>{{ $file->basename() }}</td>
							<td class="hidden-xs">{{ $file->size() }}</td>
							<td><a href="#" class="btn btn-transparent btn-md row-remove"><i class="ti-trash"></i></a></td>
						</tr>
						@endforeach
						@endif
					</tbody>
					</table>
                    </div>
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

@foreach($resource_js as $r_js)
<script src="{{ asset($r_js) }}"></script>
@endforeach

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.3/tinymce.min.js"></script>
<script>
$(document).ready(function() {
@if ($model->files)
	File.init({size: {{$model->maxFileSize}}});
	if ($('select.dynamic').length){
    	Select.init();
	}
@endif
Textarea.init("{{ asset('panel_assets/js/tinymce_es_MX.min.js') }}");
Colorpicker.init();
Structure.init();
});
</script>
@endsection