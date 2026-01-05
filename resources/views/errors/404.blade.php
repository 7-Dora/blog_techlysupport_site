@extends('layout')

@push('styles')
    <link rel="stylesheet" href="/css/custom-404.css?v=1.2">
@endpush

@section('content')
    <div class="error-container">
        <h1 class="error-code">404</h1>
        <h2 class="error-message">{{ \App\Models\MaterielTask::page_not_found(app()->getLocale()) }}</h2>
        <p class="error-description">
            {{ \App\Models\MaterielTask::desc_1_404(app()->getLocale()) }}<br>
            {{ \App\Models\MaterielTask::desc_2_404(app()->getLocale()) }}
        </p>
        <a href="{{ app()->getLocale() === 'en' ? route('home') : route('home.localized', ['locale' => app()->getLocale()]) }}" class="btn-home">
            <i class="fas fa-home me-2"></i> {{ \App\Models\MaterielTask::go_to_homepage(app()->getLocale()) }}
        </a>
    </div>
@endsection