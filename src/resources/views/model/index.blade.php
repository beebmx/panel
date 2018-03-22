@section('title', __('panel::index.title', ['title' => strtolower($model->name)]))
@section('module', 'index')
@extends('panel::layouts.panel')

@section('content')
<h4 class="title is-4">{{ $model->name }}</h4>
<panel-content>
    <div slot="header" class="columns is-multiline">
        <div class="column">
            SEARCH
        </div>
        @if ($permissions->get('create'))
        <div class="column">
            BUTTON
        </div>
        @endif
    </div>
    <panel-table-view :headers="{{ $headers }}" :rows="{{ $rows }}" :permission="{{ $permissions }}"></panel-table-view>
</panel-content>
@endsection

@section('js')
@endsection
