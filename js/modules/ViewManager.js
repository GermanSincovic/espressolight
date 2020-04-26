import {RequestController} from "./RequestController.js";

export var ViewManager = {
    template: undefined,
    data: undefined,

    render: function( template ){
        this.toggleSpinner();
        RequestController.getTemplate( template );
        this.toggleSpinner();
    },
    toggleSpinner: function() {
        $("#navigation").toggleClass("blur");
        $("#main").toggleClass("blur");
        $("#spinner").toggleClass("hidden");
    }

};