$(document).ready(function() {
    
    $('#registerForm').on('submit', function(e) {
        
        e.preventDefault(); 
        $('#errors').html('');
        var formData = new FormData(this);
        formData._token = $('input[name="_token"]').val();
        console.log(formData);
        console.log(window.appUrl);
        if(formData.get('name') == '' || formData.get('email') == '' || formData.get('password') == '' || formData.get('password_confirmation') == '') {
            $('#errors').html('<ul><li>All fields are required</li></ul>');
            return false;
        }

        if(formData.get('email').indexOf('@') == -1) {
            $('#errors').html('<ul><li>Invalid email address</li></ul>');
            return false;
        }

        if(formData.get('password') != formData.get('password_confirmation')) {
            $('#errors').html('<ul><li>Passwords do not match</li></ul>');
            return false;
        }
        $.ajax({
            url: window.appUrl+'/register_user',  // This matches the route defined in routes/api.php
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                var token = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token
                xhr.setRequestHeader('X-CSRF-TOKEN', token); // Set it in the request header
            },
            success: function(response) {
                swal("", "Registration successful!", "success");
                
                window.location.href = '/login'; 
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
                    $('#errors').html(errorMessages);
                }
            }
        });
    });


    // login form
    $("#loginForm").on('submit', function(e) {
        e.preventDefault();
        $('#loginerrors').html('');
        var formData = new FormData(this);
        if(formData.get('email') == '' || formData.get('password') == '') {
            $('#loginerrors').html('<ul><li>All fields are required</li></ul>');
            return false;
        }
        $.ajax({
            url: window.appUrl+'/login_user',  // This matches the route defined in routes/api.php
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
                window.location.href = '/user/books'; 
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
                    $('#loginerrors').html(errorMessages);
                }
                else if(message) {
                    $('#loginerrors').html('<ul><li>'+message+'</li></ul>');
                }
            }
        })

    });
});