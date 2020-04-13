import {ViewManager} from "./ViewManager.js";

export var Router = {
    pathParams: '',
    init: function () {
        this.pathParams = window.location.pathname.split('/').filter( e => {return !!e});
        ViewManager.init(this.pathParams);
    }
};