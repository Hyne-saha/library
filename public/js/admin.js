$(document).ready(function(){
    // handle login form
    


$(function() {
    const userId = $("#user_id").val();
    $('#book_list').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: window.appUrl+'/admin/getAllBooks',  
            type: 'GET',
            data: {userId : userId}
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'author', name: 'author' },
            { data: 'title', name: 'title' },
            { data: 'created_at', name: 'borrowed', render: function(data, type, row) {
                // console.log(row.transactions);
                return formatDate(data);
            } },
            { data: 'action', name: 'action', orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    // console.log(row);
                    // console.log($("#user_id").val());
                    return `<button class="btn btn-danger delete-btn" data-id="${row.id}" onclick="deleteBook(this)" ><span><i class="bi bi-trash3"></i></span></button>`;
                   
                    
                   
                } }
             ]
    });
});


// insert boo
$('#addBookForm').on('submit', function(e) {
    const userId = $("#user_id").val();     
    e.preventDefault(); 
    $('#bookerrors').html('');
    var formData = new FormData(this);
    console.log(formData);
    console.log(window.appUrl);
    if(formData.get('name') == '' || formData.get('title') == '') {
        $('#bookerrors').html('<ul><li>All fields are required</li></ul>');
        return false;
    }
    formData.append('user_id', userId);
    $.ajax({
        url: window.appUrl+'/admin/addBook',  // This matches the route defined in routes/api.php
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function(xhr) {
            var token = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token
            xhr.setRequestHeader('X-CSRF-TOKEN', token); // Set it in the request header
        },
        success: function(response) {
            swal("", "Book Added!", "success");

            $(".close_modal").click();
            $('#addBookForm')[0].reset();

            $('#book_list').DataTable().ajax.reload();
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            if (errors) {
                var errorMessages = '<ul>';
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        errorMessages += '<li>' + errors[key].join(', ') + '</li>';
                    }
                }
                errorMessages += '</ul>';
                $('#bookerrors').html(errorMessages);
            }
        }
    });
});


// list all users
$(function() {
    const userId = $("#user_id").val();
    $('#user_list').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: window.appUrl+'/admin/getAllUsers',  
            type: 'GET',
            beforeSend: function(xhr) {
                var token = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token
                xhr.setRequestHeader('X-CSRF-TOKEN', token); // Set it in the request header
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at', render: function(data, type, row) {
                return formatDate(data);
            } },
            { data: 'action', name: 'action', orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<button class="btn btn-danger delete-btn" data-id="${row.id}" onclick="deleteUser(this)" ><span><i class="bi bi-trash3"></i></span></button>`;
                } }
             ]
    });
});


// list all book details

$(function() {
    $('#book_details').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: window.appUrl+'/admin/book_details',  
            type: 'GET',
            beforeSend: function(xhr) {
                var token = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token
                xhr.setRequestHeader('X-CSRF-TOKEN', token); // Set it in the request header
            },
        },

        columns: [
            { data: 'id', name: 'id' },
            { data: 'book.title', name: 'book.title' },
            { data: 'book.author', name: 'book.author' },
            { data: 'user.name', name: 'user.name' },
            { data: 'status', name: 'status' , render: function(data, type, row){
                if(data == 'borrowed'){
                    return '<span class="badge bg-danger">Borrowed</span>';
                }
                else{
                    return '<span class="badge bg-success">Returned</span>';
                }
            }},
            { data: 'borrwed_at', name: 'borrwed_at', render: function(data, type, row) {
                if(data == null){
                    return 'NA';
                }
                else{
                    return formatDate(data);
                }
            } },
            { data: 'returned_at', name: 'returned_at' , render: function(data, type, row) {
                if(data == null){
                    return 'NA';
                }
                else{
                    return formatDate(data);
                }
            }},
            { data: 'fine', name: 'fine' , render: function(data, type, row){
                console.log(row);
                const today = new Date();
                const formattedDate = today.toISOString().split('T')[0];

                const due_days = diffInDays(row.borrwed_at, formattedDate);
                const fine_days = due_days - 7;

                console.log(due_days + ' ' + fine_days+ ' ' + row.fine);
                if(due_days > 7 && (row.fine == '0.00' || row.fine == null)){
                    const fine_perday = 10;
                    const fine = fine_days * fine_perday;
                    return '<span class="badge bg-danger">&#8377; '+fine+'</span>';
                }
                else if(data > 0){
                    return '<span class="badge bg-success">&#8377; '+row.fine+'</span>';
                }
                else{
                    return '<span class="badge bg-success">NA</span>';
                }
            }}
             ]
    });
});




});

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

function deleteBook(mythis){
    var book_id = $(mythis).data('id');
    $.ajax({
        url: window.appUrl+'/admin/deleteBook',
        type: 'POST',
        data: {book_id: book_id},
        beforeSend: function(xhr) {
            var token = $('meta[name="csrf-token"]').attr('content');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
        },
        success: function(response){
            console.log(response);
            $('#book_list').DataTable().ajax.reload();
        }
    })
}

function deleteUser(mythis){
    var user_id = $(mythis).data('id');
    $.ajax({
        url: window.appUrl+'/admin/deleteUser',
        type: 'POST',
        data: {user_id: user_id},
        beforeSend: function(xhr) {
            var token = $('meta[name="csrf-token"]').attr('content');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
        },
        success: function(response){
            console.log(response);
            $('#user_list').DataTable().ajax.reload();
        }
    })

}