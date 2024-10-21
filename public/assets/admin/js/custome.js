$(function() {
    'use strict'
    // Check Old Admin Password
    $("#old_password").keyup(function (){
        var current_password = $("#old_password").val();
        $.ajax({
            type:'post',
            url:'check_admin_password',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{current_password:current_password},
            "_token": "{{ csrf_token() }}",
            success:function (response){
                if(response == "true"){
                    $("#check_password").html('<p style="color:green"> كلمة المرور صحيحة </p>');
                }else if(response == 'false'){
                    $("#check_password").html('<p style="color:red"> كلمة المرور خطا </p>');
                }
            },
            error:function (){
                alert('Error');
            }
        });
    });



});
