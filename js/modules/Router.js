import {ViewManager} from "./ViewManager.js";

export var Router = {
    pathParams: '',
    url: '',
    urlPattern: '',
    viewMapping: {
        "":  ["main", null],
        "branches": ["branches", null],
        "users": ["users", "/api/v1/users"],
        "users/{id}": ["user", "/api/v1/users/{id}"],
        "accounts": ["accounts", "/api/v1/accounts"]
    },
    init: function () {
        this.pathParams = window.location.pathname.split('/').filter( e => {return !!e});
        this.url = this.pathParams.join('/');
        this.getUrlPattern();
        ViewManager.render(
            this.viewMapping[this.urlPattern] ? this.viewMapping[this.urlPattern][0] : "404",
            this.viewMapping[this.urlPattern] ? this.viewMapping[this.urlPattern][1] : ""
        );
    },
    getUrlPattern: function(){
        let tmparr = [];
        this.pathParams.forEach(function(element){
            element.match(/^\d+$/)? tmparr.push( "{id}" ) : tmparr.push( element ) ;
        });
        this.urlPattern = tmparr.join("/");
    },
    redirectTo: function(href){
        history.pushState(null, null, href);
    }
};
