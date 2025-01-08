$(document).ready(function(){
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    
    // data table
$(function() {
    const userId = $("#user_id").val();
    $('#books_table').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: window.appUrl+'/user/getBooks',  // Set your route for fetching data
            type: 'POST',
            data: {userId : userId},
            beforeSend: function(xhr) {
                var token = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token
                xhr.setRequestHeader('X-CSRF-TOKEN', token); // Set it in the request header
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'author', name: 'author' },
            { data: 'title', name: 'title' },
            { data: 'created_at', name: 'created_at', render: function(data, type, row) {
                // console.log(row.transactions);
               
                return formatDate(data);
            } },
            
            { data: 'action', name: 'action', orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    console.log(row);
                    // console.log($("#user_id").val());
                    if(row.transactions.length > 0){
                        var book_borrowed = row.transactions[0].status;
                        var row_user_id = row.transactions[0].user_id;
                        var borrowed_date = row.transactions[0].borrwed_at;
                        var transaction_id = row.transactions[0].id;
                    }
                    else{
                        var book_borrowed = null;
                        var row_user_id = null;
                        var borrowed_date = null;
                        var transaction_id = null;
                    }

                    
                    if(book_borrowed == 'borrowed' && row_user_id == userId){
                        return `<button class="btn btn-danger delete-btn" data-val ="${transaction_id}" data-value="${borrowed_date}" data-id="${row.id}"  onclick="openReturnModal(this)" >Check Return</button>`;
                    }
                    else{
                        return `<button class="btn btn-primary edit-btn" data-id="${row.id}" onclick="borrowBook(this)">Borrow</button>`;
                    }
                   
                } }
             ]
    });
});
})


function borrowBook(mythis){
    var book_id = $(mythis).data('id');
    var user_id = $("#user_id").val();
    $.ajax({
        url: window.appUrl+'/user/borrowBook',
        type: 'POST',
        data: {book_id: book_id, user_id: user_id},
        beforeSend: function(xhr) {
            var token = $('meta[name="csrf-token"]').attr('content');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
        },
        success: function(response){
            console.log(response);
            swal("", "Book borrowed successfully", "success");
            $('#books_table').DataTable().ajax.reload();
        }
    })

}

function openReturnModal(mythis){
    $('#returnBookModal').modal('show');
    var borrowed_date = $(mythis).data('value');
    $("#bookId").val($(mythis).data('id'));
    $("#transaction_id").val($(mythis).data('val'));
    $('#borrowed_date').val(borrowed_date);
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    document.getElementById("return_date").value = formattedDate;

    const due_days = diffInDays(borrowed_date, formattedDate);
    const fine_days = due_days - 7;
    console.log(fine_days);
    if(due_days > 7){
        const fine_perday = 10;
        const fine = fine_days * fine_perday;
        console.log(fine);
        $(".fine_calculation").html('Delayed by '+due_days+' days. Fine: &#8377;'+fine);
        $("#fine").val(fine);
    }
    else{
        $("#fine").val(0);
    }

}

function submitBookReturn(){
    const user_id = $("#user_id").val();
    const bookId = $("#bookId").val();
    const return_date = $("#return_date").val();
    const fine = $("#fine").val();
    const transaction_id = $("#transaction_id").val();
    $.ajax({
        url: window.appUrl+'/user/returnBook',
        type: 'POST',
        data: {book_id: bookId, user_id: user_id, return_date: return_date, fine: fine, transaction_id: transaction_id},
        beforeSend: function(xhr) {
            var token = $('meta[name="csrf-token"]').attr('content');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
        },
        success: function(response){
            console.log(response);
            swal("", "Book returned successfully", "success");
            $('#books_table').DataTable().ajax.reload();
            $('#returnBookModal').modal('hide');
        }
    })
}

function diffInDays(borrowed_date, return_date){
    const date1 = new Date(borrowed_date);
    const date2 = new Date(return_date);
    const diffInTime = date2 - date1;
    const diffInDays = diffInTime / (1000 * 3600 * 24);
    return diffInDays;
}

function formatDate(inputDate) {
    // Format the date using moment.js
    var date = new Date(inputDate);

    // Format the date manually
    var day = ('0' + date.getDate()).slice(-2); // Day (02)
    var month = ('0' + (date.getMonth() + 1)).slice(-2); // Month (01-12)
    var year = date.getFullYear(); // Year (2025)
    var hours = date.getHours() % 12 || 12; // 12-hour format
    var minutes = ('0' + date.getMinutes()).slice(-2); // Minutes (00-59)
    var ampm = date.getHours() >= 12 ? 'PM' : 'AM'; // AM/PM

    // Combine into desired format
    return `${day}-${month}-${year}`;
}

