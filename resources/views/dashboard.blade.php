@extends('layouts.app')
@section('content')
    <div class="sm:w-2/3 mx-auto flex align-center justify-center h-full flex-col">
        <div class="text-center">
            <h2 class="mb-4">
                Salut {{ auth()->user()->name }} @{{test}}
            </h2>
        </div>
        <div>
            <div id="map" style="height: 600px;"></div>
            <div class="text-center mt-5">
                <a class="m-3  border-2 border-blue text-blue hover:bg-blue hover:text-white p-2 no-underline"
                   href="/auth/logout">Logout</a>
                <a class="m-3  border-2 border-blue text-blue hover:bg-blue hover:text-white p-2 no-underline" href="#"
                   onclick="clearInterval(randomInterval)">Clear</a>
            </div>

        </div>
    </div>
@endsection