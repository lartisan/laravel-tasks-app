@extends('layouts.app')

@section('content')
    <section class=" max-w-xl mx-auto">
        <div class="panel bg-white rounded-lg shadow-lg">
            <!-- Panel Header -->
            <div class="panel-header border-b border-gray-300 px-10 py-6 flex justify-between items-center">
                <h1 class="text-grey-darkest uppercase text-md font-bold">Login</h1>
            </div>

            <!-- Panel Body -->
            <div class="panel-body text-sm px-10 py-6">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                        <input class="@error('email') border-red-600 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="email" type="text" placeholder="Type your email address here..." autofocus>
                        @error('email')
                            <span class="text-xs text-red-600" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                        <input class="@error('passord') border-red-600 @enderror shadow appearance-none rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="password" type="password" placeholder="... and your super-secret password here">
                        @error('passord')
                            <span class="text-xs text-red-600" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
