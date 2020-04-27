import {ViewManager} from "./ViewManager.js";

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
    },
    getTemplate: function (template) {
        if (template) {
            $.ajax({
                url: "/view/templates/" + template + ".php",
                success: function(res){
                    $("#main").html(res);
                }
            })
        } else {
            $("#main").text("Страница не найдена");
        }
    },
    getData: function( apiEndpoint) {
        if(apiEndpoint) {
            $.ajax({
                url: apiEndpoint,
                success: function (res) {
                    ViewManager.insertData(Array(res));
                }
            })
        } else {
            ViewManager.insertData();
        }
    }
};

function loginFailedMessage(){
    if(!$("#login_failed_message")[0]) {
        $("<small class='text-danger' id='login_failed_message'>Логин или пароль неверный</small>").insertBefore("#login");
    }
}