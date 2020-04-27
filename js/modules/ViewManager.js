import {RequestController} from "./RequestController.js";

export var ViewManager = {
    template: undefined,
    data: undefined,

    render: function(template, apiEndpoint){

        $("#main").toggleClass("hidden");
        ViewManager.toggleSpinner();
        RequestController.getTemplate(template);
        RequestController.getData(apiEndpoint);
    },
    toggleSpinner: function() {
        $("#navigation").toggleClass("blur");
        $("#main").toggleClass("blur");
        $("#spinner").toggleClass("hidden");
    },
    insertData: function(data = null){
        if(data) {
            const wrapper = $("[data-chunk='wrapper']").removeAttr("data-chunk");
            const template = wrapper[0].firstElementChild.outerHTML;
            wrapper[0].firstElementChild.remove();

            data.forEach((elem) => {
                wrapper.append(template.replace(/\{\{(\w+)\}\}/gm, function (match, p1) {
                    return elem[p1];
                }));
            });
        }


        this.toggleSpinner();
        $("#main").toggleClass("hidden");
    }

};