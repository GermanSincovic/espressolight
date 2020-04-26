import {ViewManager} from "./ViewManager.js";

export var Router = {
    pathParams: '',
    url: '',
    urlPattern: '',
    viewMapping: {
        "":  "main",
        "branches": "branches",
        "users": "users"
    },
    init: function () {
        this.pathParams = window.location.pathname.split('/').filter( e => {return !!e});
        this.url = this.pathParams.join('/');
        this.getUrlPattern();
        ViewManager.render( this.viewMapping[this.urlPattern] );
    },
    getUrlPattern: function(){
        let tmparr = [];
        this.pathParams.forEach(function(element){
            element.match(/^\d+$/)? tmparr.push( "{id}" ) : tmparr.push( element ) ;
        });
        this.urlPattern = tmparr.join("/");
    }
};
