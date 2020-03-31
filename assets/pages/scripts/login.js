$("#login-form").submit(function(event){
    $("#notification").html("");
    event.preventDefault();
    var form_data = new FormData($(this)[0]);
    $.ajax({
        url : base_url+"main/proses_login",
        type : "post",
        data : form_data,
        dataType : "json",
        async : false,
        cache : false,
        contentType : false,
        processData : false,
        beforeSend : function(){
            App.blockUI({
                target: '#login-form',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#login-form');
        },
        success : function(data) {
            $("#notification").html(data.message);
            $('#parent_notification').removeClass('display-hide').addClass('display-show');
            if(data.status==200){
                $('#parent_notification').removeClass('alert-danger').addClass('alert-success');
                window.location.href = data.url;
            }
        },
        error : function(){
            $('#parent_notification').removeClass('display-hide').addClass('display-show');
            $("#notification").html("Username atau password salah");
        }
    });
    return false;
});