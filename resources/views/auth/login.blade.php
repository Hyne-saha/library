@extends('layouts.app')
@section('title', 'Login')
@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="section w-50">
            <h2>Login</h2>
            <form id="loginForm">                
                @csrf
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="">
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>

            

                <div class="mb-3"> 
                    <button type="submit" class="btn btn-primary ms-auto d-block">Login</button>
                </div>

                <div class="mb-3"> 
                    <a href="{{ route('auth.register') }}" >Click here to register</a>
                </div>
                
            </form>

   
    <div id="loginerrors" style="color: red;"></div>

            <div id="errors" style="color: red;"></div>
        </div>
    </div>

@section('scripts')
    <script src="{{ asset('js/register.js') }}"></script>
@endsection
