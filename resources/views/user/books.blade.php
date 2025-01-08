@extends('layouts.app')
@section('title', 'Books')
@section('content')

<div class="container d-flex justify-content-center min-vh-100 mx-auto text-center mt-5 d-block">
        <div class="section w-100">
            <h2>Book List</h2>
            
            <input type="hidden" id="user_id" value="{{ $userlist->id }}">
                <table class="table table-bordered" id="books_table">
                <thead>
                <tr>
                    <th>Book No</th>
                    <th>Author Name</th>
                    <th>Title</th>
                    <th>Created Date</th>
                    <th>Action</th>
                </tr>
                </thead>


            </table>
   
    
        </div>
        </div>
         <!-- modal -->
    <div class="modal fade" id="returnBookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Return Book</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form id="returnBookForm" method="POST" action="javascript:void(0)">        
                                @csrf

                                <input type="hidden" id="bookId" value="">
                                <input type="hidden" id="transaction_id" value="">
                                <div class="mb-3">
                                    <label for="borrowed">Borrowed Date</label>
                                    <input type="text" name="borrowed" class="form-control" id="borrowed_date" value="" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="return">Return Date</label>
                                    <input type="text" name="return" class="form-control" id="return_date" value="" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="email">Fine (&#8377;10 per day if the duration exceeds 7 days) <span class="fine_calculation color-red"></span></label>
                                    <input type="text" name="fine" class="form-control" id="fine" value="" disabled>
                                </div>

                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close_modal" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary ms-auto d-block" onclick="submitBookReturn()">Return</button>
                                </div>
                            </form>

                            <div id="bookerrors" style="color: red;"></div>
                            </div>
                            
                            </div>
                        </div>
                        </div>
         <!-- end -->
    

@section('scripts')
    <script src="{{ asset('js/book.js') }}"></script>
@endsection