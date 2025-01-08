@extends('layouts.admin')
@section('title', 'Admin Login')
@section('content')

<div class="container d-flex">
        <div class="section w-100">
           
        <div class="">
            <button class="btn btn-primary" id="addBook"  data-bs-toggle="modal" data-bs-target="#exampleModal">Add Books</button>
        </div>
        <input type="hidden" id="user_id" value="{{ $adminUser->id }}">
        <table class="table table-bordered" id="book_list">
        <thead>
        <tr>
            <th>Book No</th>
            <th>Author Name</th>
            <th>Title</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
        </thead>
        </table>

        </div>



        <!-- modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form id="addBookForm">        
                                @csrf
                                <div class="mb-3">
                                    <label for="name">Author Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="">
                                </div>

                                <div class="mb-3">
                                    <label for="email">Title</label>
                                    <input type="text" name="title" class="form-control" id="title" value="">
                                </div>

                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close_modal" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary ms-auto d-block">Submit</button>
                                </div>
                            </form>

                            <div id="bookerrors" style="color: red;"></div>
                            </div>
                            
                            </div>
                        </div>
                        </div>
         <!-- end -->
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection