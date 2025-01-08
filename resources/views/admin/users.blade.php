@extends('layouts.admin')
@section('title', 'Admin Users')
@section('content')

<div class="container d-flex">
        <div class="section w-100">
           <h3>Users</h3>
       
        <input type="hidden" id="user_id" value="{{ $userlist->id }}">
        <table class="table table-bordered" id="user_list">
        <thead>
        <tr>
            <th>User No</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
        </thead>
        </table>

        </div>



        
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection