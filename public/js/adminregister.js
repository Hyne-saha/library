$(document).ready(function() {
    $("#adminloginForm").on('submit', function(e) {
        e.preventDefault();
        $('#adminerrors').html('');
        var formData = new FormData(this);
        if(formData.get('email') == '' || formData.get('password') == '') {
            $('#adminerrors').html('<ul><li>All fields are required</li></ul>');
            return false;
        }
        $.ajax({
            url: window.appUrl+'/admin_login',  // This matches the route defined in routes/api.php
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                // Get the CSRF token from the meta tag
                var token = $('meta[name="csrf-token"]').attr('content');
                // Set the CSRF token in the request header
                xhr.setRequestHeader('X-CSRF-TOKEN', token);
            },
            success: function(response) {
                console.log(response);
                swal("", "Login successful!", "success");
                window.location.href = '/admin/addbooks'; 
            },
            error: function(xhr) {
                console.log(xhr);
                var errors = xhr.responseJSON.errors;
                var message = xhr.responseJSON.message;
                if (errors) {
                    var errorMessages = '<ul>';
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorMessages += '<li>' + errors[key].join(', ') + '</li>';
                        }
                    }
                    errorMessages += '</ul>';
                    $('#adminerrors').html(errorMessages);
                }
                else if(message) {
                    $('#adminerrors').html('<ul><li>'+message+'</li></ul>');
                }
            }
        })

    });


});