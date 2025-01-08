@extends('layouts.admin')
@section('title', 'Book Details')
@section('content')

<div class="container d-flex">
        <div class="section w-100">
           <h3>Book Details</h3>
       
        <input type="hidden" id="user_id" value="{{ $userlist->id }}">
        <table class="table table-bordered" id="book_details">
        <thead>
        <tr>
            <th>User Id</th>
            <th>Book Name</th>
            <th>Author</th>
            <th>User Borrowed</th>
            <th>Book Status</th>
            <th>Borrowed at</th>
            <th>Returned at</th>
            <th>Fine</th>
        </tr>
        </thead>
        </table>

        
    </div>



        
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection