export var RequestController = {

    login: function () {
        $.ajax({
            url: "/api/v1/auth/login",
            type: "POST",
            data: {
                "login": $("#login")[0].value,
                "password": $("#password")[0].value
            },
            dataType: "json",
            success: function () {
                window.location.href = "/";
            },
            error: function () {
                loginFailedMessage();
            }
        });
    },
    logout: function () {
        $.ajax({
            url: "/api/v1/auth/logout",
            type: "POST",
            dataType: "json",
            success: function(){
                window.location.href = "/";
            }
        });
    }
};

function loginFailedMessage(){
    if($("#login_failed_message")[0] == undefined) {
        $("<small class='text-danger' id='login_failed_message'>Логин или пароль неверный</small>").insertBefore("#login");
    }
}