@section('title', 'Listado de '.strtolower($model->name))
@section('module', 'index')
@extends('panel::layouts.panel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <h3 class="index-title padding">Listado de {{ $model->name }}</h3>
    </div>
</div>
<div class="container-fluid panel-container bg-gray">
    <div class="row controls">
        <div class="col-sm-3">
            @if ($model->create)
                @if ($parent === null)
            <a class="btn btn-primary btn-block create" href="{{ url(config('panel.prefix').'/page/'.$model->url).'/create' }}">Nuevo registro</a>
                @else
            <a class="btn btn-primary btn-block create" href="{{ url(config('panel.prefix').'/page/'.$parent.'/'.$parent_id.'/'.$model->url).'/create' }}">Nuevo registro</a>
                @endif
            @endif
        </div>
        <div class="col-sm-offset-3 col-sm-6">
            <form>
                <div class="form-group search">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control" placeholder="Buscar">
                        <span class="input-group-btn">
                            <button type="submit" class="btn"><span class="fa fa-search"></span></button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                @foreach($fields as $id)
                <th {!! $model->fields[$id]['mobile'] ? '' : 'class="hidden-xs hidden-sm"' !!}>{{ $model->fields[$id]['name'] }}</th>
                @endforeach
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($list as $index => $field)
                <tr>
                    @foreach($fields as $id)
                    <td {!! $model->fields[$id]['mobile'] ? '' : 'class="hidden-xs hidden-sm"' !!}>{!! $field[$id] !!}</td>
                    @endforeach
                    <td class="table-controls text-center">
                        @if ($parent === null)
                        <form class="delete-form" role="form" action="{{ url(config('panel.prefix').'/page/'.$model->url.'/'.$data[$index][$idField]) }}" method="post">
                        @else
                        <form class="delete-form" role="form" action="{{ url(config('panel.prefix').'/page/'.$parent.'/'.$parent_id.'/'.$model->url.'/'.$data[$index][$idField]) }}" method="post">
                        @endif
							{!! method_field('delete') !!}
							{!! csrf_field() !!}
						</form>
                        <div class="hidden-xs hidden-sm btn-group btn-group-sm" role="group" aria-label="...">
                            @if ($parent === null)
                            <a class="btn btn-default" href="{{ url(config('panel.prefix').'/page/'.$model->url.'/'.$data[$index][$idField]) }}"><i class="material-icons">pageview</i></a>
                            @else
                            <a class="btn btn-default" href="{{ url(config('panel.prefix').'/page/'.$parent.'/'.$parent_id.'/'.$model->url.'/'.$data[$index][$idField]) }}"><i class="material-icons">pageview</i></a>
                            @endif
                            
                            
                            
                            
                            @if ($model->update)
                                @if ($parent === null)
                            <a class="btn btn-default" href="{{ url(config('panel.prefix').'/page/'.$model->url.'/'.$data[$index][$idField].'/edit') }}"><i class="material-icons">mode_edit</i></a>
                                @else
                            <a class="btn btn-default" href="{{ url(config('panel.prefix').'/page/'.$parent.'/'.$parent_id.'/'.$model->url.'/'.$data[$index][$idField].'/edit') }}"><i class="material-icons">mode_edit</i></a>
                                @endif
                            @endif
                            @if ($model->delete)
                            <a class="btn btn-default delete-data" href="#"><i class="material-icons">delete</i></a>
                            @endif
                        </div>
                        
                        <div class="hidden-md hidden-lg dropdown">
                            <a class="btn btn-default" id="controls" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">settings</i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="controls">
                                @if ($parent === null)
                                <li><a href="{{ url(config('panel.prefix').'/page/'.$model->url.'/'.$data[$index][$idField]) }}">Ver</a></li>
                                @else
                                <li><a href="{{ url(config('panel.prefix').'/page/'.$parent.'/'.$parent_id.'/'.$model->url.'/'.$data[$index][$idField]) }}">Ver</a></li>
                                @endif
                                @if ($model->update)
                                    @if ($parent === null)
                                <li><a href="{{ url(config('panel.prefix').'/page/'.$model->url.'/'.$data[$index][$idField].'/edit') }}">Editar</a></li>
                                    @else
                                <li><a href="{{ url(config('panel.prefix').'/page/'.$parent.'/'.$parent_id.'/'.$model->url.'/'.$data[$index][$idField].'/edit') }}">Editar</a></li>
                                    @endif
                                @endif
                                @if ($model->delete)
                                <li><a class="delete-data" href="#">Eliminar</a></li>
                                @endif
                            </ul>
                        </div>
                        
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="panel-paginator">{{ $data->links() }}</div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
	Panel.index();
});
</script>
@endsection
