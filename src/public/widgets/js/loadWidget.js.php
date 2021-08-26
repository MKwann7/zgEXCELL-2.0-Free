function WidgetLoader(componentId, app, domEl, mainEntity, propData, uri)
{
    let vueApp;
    let domElement;
    let mainComponentId;
    let uriBase;
    let entity;
    let props;
    let mainEntityList;

    const __construct = function(widget)
    {
        mainComponentId = componentId;
        vueApp = app;
        domElement = domEl;
        uriBase = uri;
        entity = mainEntity;
        props = propData;

        load();
    }

    const load = function(widget)
    {
        try
        {
            vueApp.userId = "73a0d8b4-57e9-11ea-b088-42010a522005";
            vueApp.vc = new vueComponents(vueApp, domElement, "hub", uriBase);

            Vue.component('v-style', {
                render: function (createElement) {
                    return createElement('style', this.$slots.default)
                }
            })
        }
        catch(ex)
        {
            console.log(ex);
        }
    }

    this.runMain = function(action, callback)
    {
        vueApp.vc.loadComponentByStaticId( mainComponentId, "", action, entity, mainEntityList, props, true, true, function(component) {
            if (typeof callback === "function") callback(component);
        });
    }

    this.runChild = function(child, action, callback)
    {
        vueApp.vc.loadComponentByStaticId( mainComponentId, "", action, entity, mainEntityList, props, false, true, function(parentComponent) {
            vueApp.vc.loadComponentByStaticId(child, parentComponent.instanceId, action, entity, mainEntityList, props, true, true, function(component)
            {
                if (typeof callback === "function") callback(component, parentComponent);
            });
        });
    }

    __construct(componentId, app, domEl, mainEntity, propData, uri);
}