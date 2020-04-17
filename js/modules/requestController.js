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
               return ("<small class='text-danger' id='login_failed_message'>Логин или пароль неверный</small>").insertBefore("#login");
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