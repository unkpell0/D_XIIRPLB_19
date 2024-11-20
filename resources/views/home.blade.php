@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- icon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</html>
</head>
<body>
    

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
</body>
</html>
@endsection