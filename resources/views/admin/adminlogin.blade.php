@extends('layouts.admin')
@section('title', 'Admin Login')
@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="section w-50">
            <h2>Login to Admin</h2>
            <form id="adminloginForm">                
                @csrf
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="adminemail" value="">
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="adminpassword">
                </div>

            

                <div class="mb-3"> 
                    <button type="submit" class="btn btn-primary ms-auto d-block">Login</button>
                </div>

                <!-- <div class="mb-3"> 
                    <a href="#" >Click here to register</a>
                </div> -->
                
            </form>

   
    <!-- <div id="loginerrors" style="color: red;"></div> -->

            <div id="adminerrors" style="color: red;"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/adminregister.js') }}"></script>
@endsection