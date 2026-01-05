@extends('layout')

@section('title', $pageInfo->seo_title)
@section('description', $pageInfo->seo_desc)

@push('styles')
    <link rel="stylesheet" href="/css/page.css?v=1.2">
@endpush

@section('content')
<div class="hero-section py-5">
    <div class="container text-center">
        <h1>{{ data_get(data_get(data_get(\App\Models\MaterielTask::SUPPORTS(app()->getLocale()), []), $pageInfo->type, []), 'name', '') }}</h1>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="page-content">
                {!! $pageInfo->content !!}
            </div>
        </div>
    </div>
</div>
@endsection

