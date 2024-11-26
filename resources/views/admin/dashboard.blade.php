@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="border-2 w-[29rem] mx-auto border-sky-900 h-fit max-h-dvh py-4">
        <h2 class="text-5xl font-bold text-center items-center">Hi <span class="text-7xl font-bold text-red-600">{{ Auth::user()->name }}!</span></h2>
    </div>
</div>
@endsection
