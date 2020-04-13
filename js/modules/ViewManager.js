

export var ViewManager = {
    page: undefined,
    component: undefined,
    action: undefined,
    assemblyPage: function( page, component, action ) {
      console.log(page + '\n' + component + '\n' + action);
    },
    init: function (pathParams) {
        this.page       = pathParams[0] ? pathParams[0] : 'index';
        this.component  = pathParams[1] ? pathParams[1] : undefined;
        this.action     = pathParams[2] ? pathParams[2] : undefined;
        this.assemblyPage(this.page, this.component, this.action);
    }
};