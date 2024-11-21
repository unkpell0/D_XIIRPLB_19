@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-2xl font-inter">Selamat datang, <span class="text-pink-500">{{ Auth::user()->name }}!</span></h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection