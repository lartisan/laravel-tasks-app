@extends('layouts.app')

@section('content')
    <section class=" max-w-5xl mx-auto">
        <small class="flex justify-end text-xs text-indigo-400 my-2">
            Logged in as
            <span class="font-bold ml-1"> {{ auth()->user()->name }}</span>
        </small>

        <tasks-app-panel
            :current-user="{{ auth()->user() }}"
        ></tasks-app-panel>
    </section>
@endsection
