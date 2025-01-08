@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="section w-50">
            <h2>Register</h2>
            <form id="registerForm">
                @csrf
                <!-- registration form -->
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="">
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="">
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                </div>

                <div class="mb-3"> 
                    <button type="submit" class="btn btn-primary ms-auto d-block">Register</button>
                </div>

                <div class="mb-3"> 
                    <a href="{{ route('auth.login') }}" >Click here to login</a>
                </div>
            </form>

            <div id="errors" style="color: red;"></div>
        </div>
    </div>

    @section('scripts')
    <script src="{{ asset('js/register.js') }}"></script>
@endsection