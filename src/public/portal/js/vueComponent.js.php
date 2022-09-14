<?php
?>
const vueComponents = function(vueInstance, domEl, type, uriBase, time)
{
    let _ = this;
    this.vue = vueInstance;
    this.el = domEl;
    let elId = domEl.id;
    let vcType =  "modal";
    if (typeof type !== "undefined") { vcType = type; }
    let modal = null;
    this.parentData = {};
    let vueWrapper = null;
    this.components = [];
    let resizeSensor = null;
    let currentComponentId = null;
    let currentComponent = null;
    let newComponent = null;
    let componentParentId = null;
    let componentAction = null;
    let componentWidth = 0;
    let transitionTime = 350;
    let initialComponentLoad = false;
    let uriBasePath = uriBase;
    if (time) { transitionTime = time; }
    let isChangingComponents = false;
    let userId = vueInstance.userId;
    if (typeof userId === "undefined" || userId === null) { userId = Cookie.get("userId") }

    let userNum = vueInstance.userNum;

    const __construct = function()
    {
        vueWrapper = document.querySelectorAll("#" + elId + ">.vue-modal-wrapper")[0];
        if (typeof vueWrapper === "undefined") { renderVueModalWrapper(); }

        document.documentElement.style.setProperty('--vh', `${window.innerHeight}px`);
        document.documentElement.style.setProperty('--vhw1', `${window.innerHeight-90}px`);

        const transitionEvent = whichTransitionEvent();
        transitionEvent && vueWrapper.addEventListener(transitionEvent, function(event)
        {
            _.el.style.overflowX = "visible";
            if (!currentComponent || !newComponent || currentComponent === newComponent) { return; }
            currentComponent.style.display = "none";
            currentComponent.style.removeProperty("top");
            currentComponent.style.removeProperty("left");
            currentComponent.style.removeProperty("position");

            newComponent.style.removeProperty("top");
            newComponent.style.removeProperty("left");
            newComponent.style.removeProperty("position");

            vueWrapper.style.removeProperty("transform");
            vueWrapper.style.removeProperty("transition");
            vueWrapper.style.removeProperty("width");
        });
    }

    const renderVueModalWrapper = function()
    {
        const section = document.createElement("div");
        section.id = "vue-app-body-custom";
        section.classList.add("vue-app-body");
        section.classList.add("formwrapper-control");

        let componentNode = '<div class="vue-modal-wrapper formwrapper-control"></div>';

        section.innerHTML = componentNode;

        _.el.appendChild(section);
        vueWrapper = document.querySelectorAll("#" + elId + " #vue-app-body-custom > .vue-modal-wrapper")[0];
    }

	this.getComponentByInstanceId = function(instanceId)
	{
		for(let currComponent of Array.from(_.components))
		{
			if (currComponent.instanceId === instanceId)
			{
				return currComponent;
			}
		}

		return null;
	}

	this.getComponentFromRecord = function(componentRecord)
	{
	    let component = _.getComponentByInstanceId(componentRecord.instanceId);

	    if (component === null) { component = _.getComponentById(componentRecord.id); }

		return component;
	}

	this.getComponents = function()
	{
		return _.components;
	}

	this.getComponentById = function(id)
	{
		for(let currComponent of Array.from(_.components))
		{
			if (currComponent.id === resolveCamelCase(id))
			{
				return currComponent;
			}
		}

		return null;
	}

	this.reloadComponents = function(instanceId)
    {
        for(let currComponent of Array.from(_.components))
        {
            if (typeof currComponent.instance !== "undefined")
            {
                componentHasVc(currComponent.instance, currComponent.instanceId, instanceId);
            }
        }
    }

    const componentHasVc = function (component, id, rootId, props)
    {
        if (component == null || typeof component.parentId === "undefined" || component.parentId === "") { return; }
        if ( typeof props === "undefined" ) { props = {}; }

        if ( typeof component.$children !== "undefined" || component.$children.length > 0)
        {
            if (id === rootId)
            {
                for(let currChild of component.$children)
                {
                    let componentProps = currChild._props;

                    if (typeof componentProps === "object")
                    {
                        props = {...props, ...componentProps }
                    }
                }
            }

            for(let currChildIndex in component.$children)
            {
                let currChild = component.$children[currChildIndex];

                if (currChild.$children.length > 0)
                {
                    if (typeof currChild.vc === "undefined")
                    {
                        componentHasVc(currChild, id, rootId, props);
                    }
                    else
                    {
                        for(let currGrandchildIndex in currChild.$children)
                        {
                            let currVcChild = currChild.$children[currGrandchildIndex];

                            if (typeof currVcChild.instanceId !== "undefined" && currVcChild.instanceId !== "")
                            {
                                if (typeof currVcChild._props !== "undefined")
                                {
                                    let refreshComponent = currChild.$children[currGrandchildIndex]._props["filterByEntityRefresh"];

                                    if (typeof refreshComponent !== "undefined" && refreshComponent === true && id === rootId)
                                    {
                                        for(let currPropIndex in currChild.$children[currGrandchildIndex]._props)
                                        {
                                            for(let currParentPropIndex in props)
                                            {
                                                if (currParentPropIndex === currPropIndex)
                                                {
                                                    currChild.$children[currGrandchildIndex]._props[currPropIndex] = props[currParentPropIndex];
                                                }
                                            }
                                        }
                                    }
                                }

                                runComponentReload(currChild.$children[currGrandchildIndex]);
                            }
                        }
                    }
                }

                runComponentReload(currChild);
            }
        }

        runComponentReload(component);

        return false;
    }

    const runComponentReload = function(component)
    {
        if (typeof component.reloadComponent === "function")
        {
            component.reloadComponent();
        }
    }

	const getParentInstanceId = function(name, componentIds)
	{
		for (let currComponent of Array.from(componentIds))
		{
			if (name === currComponent.id)
			{
				return currComponent;
			}
		}

		return null;
	}

	this.setDefaultComponentId = function(id)
    {

    }

	this.setUserId = function(id)
    {
        userId = id;
        return _;
    }

	this.addComponent = function(component, props, baseBinding)
    {
        component.baseBinding = baseBinding;
        component.props = props;
        _.components.push(_.buildComponent(component));
    }

	this.addExistingComponent = function(component, props, baseBinding)
    {
        component.baseBinding = baseBinding;
        component.props = props;
        _.components.push(_.buildComponent(component));
    }

	this.addHelper = function(helper)
    {

    }

	this.setCurrentComponentId = function(instanceId)
	{
		currentComponentId = instanceId;
		_.vue.activeComponentId = currentComponentId;
	}

	this.runComponentDismissalScript = function()
	{
        if (currentComponentId === null) return;

        let component = _.getComponentByInstanceId(currentComponentId);

        if (component.instance !== null && typeof component.instance.dismissComponent === "function")
        {
            component.instance.dismissComponent();
        }
	}

	this.getComponents = function()
    {
        return _.components;
    }

	this.backToComponent = function(methodCall)
	{
		_.runComponentDismissalScript();
		let component = _.getComponentByInstanceId(componentParentId);
		currentComponentId = component.instanceId;
		componentAction = component.action;
		showComponent(methodCall, true);
	}

	this.getCurrentComponentId = function()
    {
        return currentComponentId;
    }

	this.getCurrentComponent = function()
    {
        return _.getComponentByInstanceId(currentComponentId);
    }

	this.componentHasParent = function(componentId)
	{
		let component = _.getComponentByInstanceId(componentId);
		if (component === null) { return false; }

		if (component.disableParent === true)
		{
			return false;
		}

        if (componentParentId === null && (vcType === "modal" || vcType === "hub"))
		{
			return false;
		}

		if (typeof component.instance.getParentLinkActions !== "function")
        {
            return true;
        }

		let parentLinkActions = component.instance.getParentLinkActions();

        if (typeof parentLinkActions !== "object")
        {
            return true;
        }

        if ( parentLinkActions.length === 0)
        {
            return true;
        }

		if (!parentLinkActions.includes(componentAction))
		{
			return false;
		}

		return true;
	}

	this.loadComponentByInstance = function(component, show, hydrate, callback)
	{
		_.loadComponent(component.instanceId, component.id, component.parentInstanceId, component.action, component.instance.getModalTitle(component.action), component.instance.entity, component.instance.entities, {}, show, hydrate, callback);
	}

	this.loadComponentByStaticId = function(id, parent, action, entity, entities, props, show, hydrate, callback)
    {
        _.loadComponent(uuidv4(), id, parent, action, "", entity, entities, props, show, hydrate, callback);
    }

    this.registerParentComponent = function(component)
    {
        if (typeof component.instance.parentData !== "unknown") {
            _.parentData = component.instance.parentData;

            const bolCheck = component.instance.parentData;
        }
        else {  _.parentData = {}; }

        return this;
    }

    this.getComponent = function(instanceId, id, parentInstanceId, action, title, entity, entities, props)
    {
        if (typeof id === "undefined" || id === null)
        {
            console.log("No Widget id handed in to modal.");
        }

        if (typeof instanceId === "undefined" || instanceId === null)
        {
            console.log("Instance Id for widget id " + id + " missing for modal.");
        }

        instanceId = resolveCamelCase(instanceId);
        id = resolveCamelCase(id);
        let component = _.getComponentByInstanceId(instanceId);

        if (component === null) {
            component = _.getComponentById(id);
        }

        if (component !== null) {
            instanceId = component.instanceId;
            parentInstanceId = component.parentInstanceId;
        }

        if (typeof component !== "undefined" && component != null) {
            hydrateComponent(instanceId, parentInstanceId, action, entity, entities, props, true)
            return _.getComponentByInstanceId(instanceId)
        }

        return null
    }

    this.loadComponent = function(instanceId, id, parentInstanceId, action, title, entity, entities, props, show, hydrate, callback)
	{
		if (typeof id === "undefined" || id === null)
		{
			console.log("No Widget id handed in to modal.");
		}

		if (typeof instanceId === "undefined" || instanceId === null)
		{
			console.log("Instance Id for widget id " + id + " missing for modal.");
		}

		if (typeof hydrate === "undefined")
		{
            hydrate = true;
		}

		instanceId = resolveCamelCase(instanceId);
		id = resolveCamelCase(id);
		let component = _.getComponentByInstanceId(instanceId);

		if (component === null) {
			component = _.getComponentById(id);
		}

        if (component !== null) {
            instanceId = component.instanceId;
            parentInstanceId = component.parentInstanceId;
        }

		if (typeof component !== "undefined" && component != null)
		{
		    if (hydrate === true)
            {
                hydrateComponent(instanceId, parentInstanceId, action, entity, entities, props, show)
            }

			if (show)
			{
                currentComponentId = instanceId
				showComponent()
			}

		    if (typeof callback === "function")
            {
                callback(component);
            }

			return;
		}

		getDynamicComponentFromApi(instanceId, id, parentInstanceId, action, title, entity, entities, props, show, hydrate, callback);
	}

	const processProps = function(props)
    {
        if (typeof props === "undefined" || props === null || props.length === 0) { return ""; }

         return "&props=" + btoa(JSON.stringify(props)).replace("=","_");
    }

	const getDynamicComponentFromApi = function(instanceId, id, parentInstanceId, action, title, entity, entities, props, show, hydrate, callback)
	{
		let componentApi = "<?php echo getFullPortalUrl(); ?>/modules/widget/config?widget_id=" + id + "&user_id=" + ( userId ? userId : "visitor" )

        if  (props && props.site_id) {
            componentApi = componentApi + "&site_id=" + props.site_id
        }

        componentApi = componentApi + processProps(props)

		if (show) {
			_.addAjaxClass();
		}

		ajax.GetExternal(componentApi, true, function(result) {
			if (result.success === false) {
				return;
			}

			let widgetBase64 = null;

			try {
                widgetBase64 = atob(result.response.widget)
            }
            catch(ex) {
                if (typeof modal !== "undefined" && modal !== null) {
                    modal.DisplayAlert({title:"Dynamic Vue Error", html: "We are unable to load the requested component from our system.<br> Error return: " + ex});
                    return;
                } else {
                    console.log("We are unable to load the requested component from our system.<br> Error return: " + ex);
                    console.log(componentApi);
                    return;
                }
            }

			let dynamicComponent = new Function(widgetBase64)();

			if (typeof dynamicComponent === "undefined") {
                console.log("Widget Id failed to load: " + id)
                return;
            }

			if (typeof dynamicComponent["main"] === "undefined") {
                if (typeof dynamicComponent.instanceId !== "undefined") {
                    instanceId = dynamicComponent.instanceId;
                }

                const componentSubId = createComponentNode(instanceId, dynamicComponent);

                let newComponent = loadDynamicComponent(dynamicComponent, instanceId, id, componentSubId, parentInstanceId, action, title, entity, entities, props, show, hydrate);

                if (typeof callback === "function") {
                    callback(newComponent);
                }
				return;
			}

            if (typeof dynamicComponent["main"].instanceId !== "undefined") {
                instanceId = dynamicComponent["main"].instanceId;
            }

            const componentSubId = createComponentNode(instanceId, dynamicComponent["main"]);

			if (typeof dynamicComponent["helpers"] !== "undefined") {
				let componentIds = buildComponentParentRelationships(dynamicComponent, instanceId, id, parentInstanceId);

				for(let currHelper of Array.from(dynamicComponent["helpers"])) {
					const currHelperName = resolveCamelCase(typeof currHelper.id === "undefined" ? currHelper.name : currHelper.id);
					const componentInstance = getParentInstanceId(currHelperName, componentIds);

                    if (typeof currHelper.instanceId !== "undefined")
                    {
                        componentInstance.instanceId = currHelper.instanceId;
                    }

					const componentSubId = createComponentNode(componentInstance.instanceId, currHelper);
					assignExpectedRootMethods(currHelper);

					const helperHydrate = (currHelper.noHydrate !== "true" ? hydrate : false)

					loadDynamicComponent(currHelper, componentInstance.instanceId, currHelperName, componentSubId, componentInstance.parentId, action, title, entity, entities, props, false, helperHydrate);
				}
			}

			let newComponent = loadDynamicComponent(dynamicComponent["main"], instanceId, id, componentSubId, parentInstanceId, action, title, entity, entities, props, show, hydrate);

            if (typeof callback === "function") {
                callback(newComponent);
            }
        });
	}

	const loadDynamicComponent = function(dynamicComponent, instanceId, id, componentSubId, parentInstanceId, action, title, entity, entities, props, show, hydrate)
	{
		if (typeof dynamicComponent.name === "undefined") {
			dynamicComponent.name = "comp" + instanceId.replace(/-/g,"");
		}

		if (parentInstanceId === "main" && typeof dynamicComponent.parent !== "undefined") {
			const parentInstance = _.getComponentById(dynamicComponent.parent);

			if (parentInstance !== null) {
				parentInstanceId = parentInstance.instanceId;
			}
		}

        if (!dynamicComponent.mountType) dynamicComponent.mountType = "default"

        dynamicComponent = loadDefaultMethodsOntoDynamicComponent(dynamicComponent);

        addDynamicComponentsMethodIfApplicable(dynamicComponent);

        const instanceRef = "comp" + instanceId.replace(/-/g,"") + "Ref";
        const newComponentItem = processComponentMount(dynamicComponent, componentSubId, instanceRef, instanceId, id, parentInstanceId, action, props)

		_.components.push(newComponentItem);

        if (hydrate === true && newComponentItem.instance !== null) {
            hydrateComponent(instanceId, parentInstanceId, action, entity, entities, props, show);
        }

        if (show && newComponentItem.instance !== null) {
			showComponent()
		}

		return newComponentItem;
	}

    this.mountComponentByInstanceId = function(componentId, componentSubId)
    {
        const instance = _.getComponentByInstanceId(componentId);

        if (instance === null) return;

        let ComponentClass = Vue.extend(instance.rawInstance);
        let newComponent = null;

        newComponent = new ComponentClass({
            parent: instance.parentVue
        }).$mount(document.getElementById(componentSubId));

        instance.instance = newComponent;
        instance.addTitle = newComponent.getModalTitle("add");
        instance.editTitle = newComponent.getModalTitle("edit");
        instance.deleteTitle = newComponent.getModalTitle("delete");
        instance.readTitle = newComponent.getModalTitle("read");
    }

	const processComponentMount = function(dynamicComponent, componentSubId, instanceRef, instanceId, id, parentInstanceId, action, props)
    {
        let ComponentClass = Vue.extend(dynamicComponent);
        let newComponent = null;

        if (componentSubId !== null && (dynamicComponent.mountType === "default" || !dynamicComponent.mountType)) {
            newComponent = new ComponentClass({
                parent: _.vue
            }).$mount(document.getElementById(componentSubId));
        }
        else if (dynamicComponent.mountType === "no_mount") {
            newComponent = new ComponentClass({
                parent: _.vue
            });
        }
        else if (dynamicComponent.mountType === "dynamic") {
            newComponent = null
        }

        let modalTitleAdd = "";
        let modalTitleEdit = "";
        let modalTitleDelete = "";
        let modalTitleRead = "";

        if (newComponent !== null) {
            newComponent.uriPath = dynamicComponent.uriPath;
            newComponent.setInstanceId(instanceId);

            modalTitleAdd = newComponent.getModalTitle("add");
            modalTitleEdit = newComponent.getModalTitle("edit");
            modalTitleDelete = newComponent.getModalTitle("delete");
            modalTitleRead = newComponent.getModalTitle("read");
        }

        return {
            instanceId: instanceId,
            id: id,
            addTitle: modalTitleAdd,
            editTitle: modalTitleEdit,
            deleteTitle: modalTitleDelete,
            readTitle: modalTitleRead,
            parentInstanceId: parentInstanceId,
            action: action,
            modalWidth: dynamicComponent.modalWidth,
            uriAbstract: dynamicComponent.uriAbstract,
            ref: instanceRef,
            instance: newComponent,
            instanceEl: dynamicComponent.name,
            parentVue: _.vue,
            rawInstance: dynamicComponent,
            mountType: dynamicComponent.mountType
        };
    }

	this.updateComponentAuths = function(isLoggedIn, authUserId)
    {
        for(let currComponentIndex in Array.from(_.components)) {
            if (typeof _.components[currComponentIndex].instance !== "undefined" && _.components[currComponentIndex].instance !== null) {
                _.components[currComponentIndex].instance.isLoggedIn = isLoggedIn;
                _.components[currComponentIndex].instance.authUserId = authUserId;
            }
        }
    }

	const addDynamicComponentsMethodIfApplicable = function(dynamicComponent)
    {
        if (typeof dynamicComponent.dynamicComponents === "function")
        {
            dynamicComponent.methods.dynamicComponents = dynamicComponent.dynamicComponents;
        }
    }

	const loadDefaultMethodsOntoDynamicComponent = function(dynamicComponent)
    {
        if (typeof dynamicComponent.methods.getModalTitle !== "function") {
            dynamicComponent.methods.getModalTitle = function(action) {
                switch(action) {
                    case "add": return "Add Entity";
                    case "edit": return "Edit Entity";
                    case "delete": return "Delete Entity";
                    case "read": return "View Entity";
                }
            }
        }

        if (typeof dynamicComponent.methods.getParentLinkActions !== "function") {
            dynamicComponent.methods.getParentLinkActions = function()
            {
                return ["add", "edit", "read", "delete"];
            }
        }

        dynamicComponent.methods.loadComponentInModal = function(instanceId, id, parentId, action, title, entity, entityList, props, show, hydrate, callback)
        {
            let vc = this.findVc(this);

            if (vc.isVcModal()) {
                vc.loadComponent(instanceId, id, parentId, action, title, entity, entityList, props, show, hydrate, callback);
            } else {
                let modal = this.findModal(this);
                if(show) { modal.show(); }
                modal.vc.loadComponent(instanceId, id, parentId, action, title, entity, entityList, props, show, hydrate, callback);
            }
        }

        dynamicComponent.methods.getUriPath = function()
        {
            return this.uriPath;
        }

        dynamicComponent.methods.backToComponent = function()
        {
            let vc = this.findVc(this);
            if (vc && typeof vc.backToComponent === "function") { vc.backToComponent(this.instanceId); }
        }

        dynamicComponent.methods.componentHasParent = function()
        {
            let vc = this.findVc(this);
            if (vc && typeof vc.componentHasParent === "function") {  return vc.componentHasParent(this.instanceId); }
            return false;
        }

        dynamicComponent.methods.showComponent = function(action)
        {
            this.$forceUpdate();
        }

        dynamicComponent.methods.engageModalLoadingSpinner = function()
        {
            let vc = this.findVc(this);
            if (vc && typeof vc.addAjaxClass === "function") { vc.addAjaxClass(); }
        }

        dynamicComponent.methods.disableModalLoadingSpinner = function()
        {
            let vc = this.findVc(this);
            if (vc && typeof vc.removeAjaxClass === "function") { vc.removeAjaxClass(); }
        }

        dynamicComponent.methods.engageComponentLoadingSpinner = function()
        {
            let vc = this.findVc(this);
            const component = vc.getComponentByInstanceId(this.instanceId);
            if (typeof component.instance.$el !== "undefined")
            {
                component.instance.$el.classList.add("ajax-loading-anim");
            }
        }

        dynamicComponent.methods.disableComponentLoadingSpinner = function()
        {
            let vc = this.findVc(this);
            const component =  vc.getComponentByInstanceId(this.instanceId);

            if (typeof component.instance.$el !== "undefined")
            {
                component.instance.$el.classList.remove("ajax-loading-anim");
            }
        }

        dynamicComponent.methods.addDynamicComponent = function(id, component)
        {
            if (typeof this[id] === "undefined" || this[id] === null)
            {
                this[id] = component;
            }
        }

        if (typeof dynamicComponent.methods.buildBreadCrumb !== "function")
        {
            dynamicComponent.methods.buildBreadCrumb = function()
            {
                return [1,2,3];
            }
        }

        dynamicComponent.methods.loadComponent = function(instanceId, id, parentInstanceId, action, title, entity, entities, props, show, hydrate)
        {
            let vc = this.findVc(this);
            if (vc && typeof vc.loadComponent === "function")
            {
                vc.loadComponent(instanceId, id, parentInstanceId, action, title, entity, entities, props, show, hydrate);
            }
        }

        dynamicComponent.methods.getComponent = function(instanceId, id, parentInstanceId, action, title, entity, entities, props, show, hydrate)
        {
            let vc = this.findVc(this);
            if (vc && typeof vc.getComponent === "function")
            {
                return vc.getComponent(instanceId, id, parentInstanceId, action, title, entity, entities, props, show, hydrate);
            }
        }

        dynamicComponent.methods.injectDefaultData = function(instanceId, parentInstanceId, action, entity, entities, props, parentData, userId, userNum)
        {
            this.action = action;
            this.entity = entity;
            this.entities = entities;
            this.userId = userId;
            this.userNum = userNum;
            this.parentId = parentInstanceId;
            this.instanceId = instanceId;
            this.loadProps(props);

            if (Object.keys(parentData).length > 0)
            {
                this.parentData = parentData;
            }

            return this;
        }

        dynamicComponent.methods.findVc = function(vue)
        {
            return this.recursiveEntityCall(vue, "vc", true);
        }

        dynamicComponent.methods.findChildVc = function(vue)
        {
            return this.recursiveForwardEntityCall(vue, "vc", true);
        }

        dynamicComponent.methods.findRootVc = function(vue)
        {
            return this.recursiveEntityCall(vue, "vc", true);
        }

        dynamicComponent.methods.loadProps = function(props)
        {
            if (typeof props === "undefined" || props === null) { return; }

            for(let currPropLabel in props)
            {
                this[currPropLabel] = props[currPropLabel];
            }
        }

        dynamicComponent.methods.fakeVc = function(vue)
        {
            return {showModal: function() {}, setTitle: function() {}};
        }

        dynamicComponent.methods.findAppVc = function(vue)
        {
            let vueApp = this.recursiveEntityCall(vue, "modal");
            if (vueApp === null || typeof vueApp.vc === "undefined") { return null; }
            return vueApp.vc;
        }

        dynamicComponent.methods.findApp = function(vue)
        {
            let vueApp = this.recursiveEntityCall(vue, "modal");
            if (vueApp === null || typeof vueApp.vc === "undefined") { return null; }
            return vueApp;
        }

        dynamicComponent.methods.recursiveEntityCall = function(vue, entityCheck, returnType)
        {
            if (typeof vue.$parent === "undefined") { return null; }
            if ( typeof vue.$parent[entityCheck] === "undefined") { return this.recursiveEntityCall(vue.$parent, entityCheck, returnType); }

            if ( returnType === true)
            {
                return vue.$parent[entityCheck];
            }

            return vue.$parent;
        }

        dynamicComponent.methods.recursiveForwardEntityCall = function(vue, entityCheck, returnType)
        {
            if (typeof vue.$children === "undefined") { return null; }

            for(let childIndex = 0; childIndex < vue.$children.length; childIndex++)
            {
                if (typeof vue.$children[childIndex][entityCheck] !== "undefined") {
                    return vue.$children[childIndex][entityCheck]
                }
            }

            return null;
        }

        dynamicComponent.methods.findModal = function(vue)
        {
            if (typeof this.modal !== "undefined") { return this.modal; }
            return this.recursiveEntityCall(vue, "modal", true);
        }

        dynamicComponent.methods.setModalComponentInstance = function(instanceId, show)
        {
            if (typeof instanceId !== "undefined")
            {
                this.instanceId = instanceId;
            }

            if (typeof this.dynamicComponents === "function")
            {
                let dynamicComponentList = this.dynamicComponents();

                let vc = this.findVc(this);
                let newComponentList = [];

                if (typeof dynamicComponentList === "undefined") return;

                for(let currComponentName in dynamicComponentList)
                {
                    let currComponentId = dynamicComponentList[currComponentName];
                    let newComponent = null;

                    if (typeof vc.getComponentFromRecord === "function")
                    {
                        newComponent = vc.getComponentFromRecord(currComponentId);
                    }

                    if (typeof newComponent !== "undefined" && newComponent !== null && newComponent.instance)
                    {
                        this.addDynamicComponent(currComponentName, newComponent.rawInstance);

                        if (typeof newComponent.instance.dynamicComponents === "function" && typeof newComponent.instance.setModalComponentInstance === "function")
                        {
                            newComponentList.push(newComponent);
                            newComponent.instance.setModalComponentInstance(newComponent.instanceId, false);
                        }
                    }
                }

                if (newComponentList.length > 0)
                {
                    for (let currComponent of newComponentList)
                    {
                        if (typeof currComponent.instance.instantiateDynamicComponents === "function")
                        {
                            currComponent.instance.instantiateDynamicComponents();
                        }
                    }
                }
            }

            this.hasParent = this.componentHasParent();

            let vc = this.findVc(this);
            if (show && vc && typeof vc.setCurrentComponentId === "function") { vc.setCurrentComponentId(instanceId); }

            return this;
        }

        dynamicComponent.methods.setInstanceId = function(id)
        {
            this.instanceId = id;
        }

        return dynamicComponent;
    }

	const buildComponentParentRelationships = function(dynamicComponent, instanceId, id, parentInstanceId)
	{
		let componentIds = [];
		instanceId = resolveCamelCase(instanceId);

		if ( id !== dynamicComponent.main.id)
        {
            id = resolveCamelCase(dynamicComponent.main.id);
        }
		else
        {
            id = resolveCamelCase(id);
        }

		parentInstanceId = resolveCamelCase(parentInstanceId);

		componentIds.push({instanceId: instanceId, id: id, parentId: parentInstanceId});

		for (let currHelper of Array.from(dynamicComponent["helpers"]))
		{
			let parentId = ((currHelper.parent) ? resolveCamelCase(currHelper.parent) : "");

			if (parentId === "main" || parentId === id)
			{
				parentId = instanceId;
			}

			let newInstanceId = uuidv4();

			componentIds.push({instanceId: newInstanceId, id: resolveCamelCase(typeof currHelper.id === "undefined" ? currHelper.name : currHelper.id), parentId: parentId});
		}

		for (let currParentIndex in componentIds)
		{
			let parentId = componentIds[currParentIndex].parentId;

			for(let currHelper of Array.from(componentIds))
			{
				if (parentId === currHelper.id)
				{
					componentIds[currParentIndex].parentInstanceId = resolveCamelCase(currHelper.instanceId);
					break;
				}
			}
		}

		return componentIds;
	}

    const getCurrentActiveComponent = function()
    {
        let activeComponent = null;
        let components = getComponentsDomInstances();

        for (let currClassIndex = 0; currClassIndex < components.length; currClassIndex++)
        {
            if (components[currClassIndex].style.display !== "none")
            {
                activeComponent = components[currClassIndex];
                break;
            }
        }

        return activeComponent;
    }

    const slideComponentsOver = function(callback)
    {
        isChangingComponents = true;
        _.el.style.overflowX = "hidden";
        newComponent.style.display = "block";
        newComponent.style.position = "absolute";
        newComponent.style.left = componentWidth + "px";
        newComponent.style.top = "0px";
        currentComponent.style.display = "block";
        currentComponent.style.left = "0px";
        currentComponent.style.top = "0px";
        currentComponent.style.position = "relative";

        vueWrapper.style.removeProperty("right");
        vueWrapper.style.removeProperty("transform");
        vueWrapper.style.removeProperty("transition");
        vueWrapper.style.position = "relative";
        vueWrapper.style.width = (componentWidth * 2) + "px";

        vueWrapper.style.transition = "transform " + transitionTime + "ms ease-out";
        vueWrapper.style.transform = "translateX(-" + componentWidth + "px)";

        window.setTimeout( function() {
            isChangingComponents = false;
            if (typeof callback === "function") {
                callback();
            }
        }, transitionTime);
    }

    const slideComponentsBack = function(callback)
    {
        isChangingComponents = true;
        _.el.style.overflowX = "hidden";
        newComponent.style.display = "block";
        newComponent.style.position = "absolute";
        newComponent.style.left = "-" +componentWidth + "px";
        newComponent.style.top = "0px";
        currentComponent.style.display = "block";
        currentComponent.style.left = "0px";
        currentComponent.style.top = "0px";
        currentComponent.style.position = "relative";

        vueWrapper.style.removeProperty("right");
        vueWrapper.style.removeProperty("transform");
        vueWrapper.style.removeProperty("transition");
        vueWrapper.style.position = "relative";
        vueWrapper.style.width = (componentWidth * 2) + "px";

        vueWrapper.style.transition = "transform 250ms ease-out";
        vueWrapper.style.transform = "translateX(" + componentWidth + "px)";

        window.setTimeout( function() {
            isChangingComponents = false;
            if (typeof callback === "function") {
                callback();
            }
        }, 250);
    }

    this.isChangingComponents = function()
    {
        return isChangingComponents;
    }

    const whichTransitionEvent = function()
    {
        let el = document.createElement('fakeelement');
        let transitions = {
            'transition':'transitionend',
            'OTransition':'oTransitionEnd',
            'MozTransition':'transitionend',
            'WebkitTransition':'webkitTransitionEnd'
        }

        for(let currTransitionIndex in transitions){
            if( el.style[currTransitionIndex] !== undefined ){
                return transitions[currTransitionIndex];
            }
        }
    }

    const calculateGoingForward = function(activeComponent, newComponent, parentComponentId)
    {
        if (activeComponent === null && (parentComponentId !== "" && parentComponentId !== null)) { return false; }
        if (activeComponent !== null) { return (parentComponentId === activeComponent.id); }
        return false;
    }

    const toggleNewComponent = function(componentElement, component, currentComponentId, parentComponentId, callback)
    {
        newComponent = componentElement;
        currentComponent = getCurrentActiveComponent();
        let goingForward = calculateGoingForward(currentComponent, component, parentComponentId);

        if ((componentParentId === null && (vcType === "modal" || vcType === "hub")) || ((component.disableParent === true) && goingForward === true) || ((currentComponent === null) && goingForward === false))
        {
            _.hideComponents();

            componentElement.style.display = "block";

            if (vcType === "app")
            {
                if (_.getInitialComponentLoad())
                {
                    appHistory.updateCurrentHistory(component.instanceId, component.parentInstanceId);
                }
                else
                {
                    if (typeof component.uriAbstract !== "undefined")
                    {
                        let newComponentUri = "/" + uriBasePath + "/" + component.uriAbstract;
                        appHistory.pushState(newComponentUri, "component", component.instanceId, component.parentInstanceId);
                    }
                }
            }

            if (typeof callback === "function") {
                callback();
            }
            return;
        }

        if (goingForward)
        {
            if (vcType === "app")
            {
                if (typeof component.uriAbstract !== "undefined")
                {
                    let newComponentUri = "/" + uriBasePath + "/" + component.uriAbstract;

                    if (newComponentUri.includes("{id}")) {
                        newComponentUri = newComponentUri.replace("{id}", component.instance.entity.sys_row_id);
                    }

                    appHistory.pushState(newComponentUri, "component", component.instanceId, component.parentInstanceId);
                }
            }
            else if (vcType === "hub")
            {
                if (typeof component.uriAbstract !== "undefined")
                {
                    let newComponentUri = (typeof uriBasePath !== "undefined" ? ("/" + uriBasePath) : "") + "/" + component.uriAbstract;



                    if (newComponentUri.includes("{card_num}"))
                    {
                        runAsyncUriUpdate(newComponentUri, component);
                    }
                    else if (newComponentUri.includes("myhub"))
                    {
                        appHistory.pushState("/myhub", "component", component.instanceId, component.parentInstanceId);
                    }
                }
            }
            slideComponentsOver(callback)
        }
        else
        {
            if (vcType === "app")
            {
                let newComponentUri = "/" + uriBasePath;
                if (component.uriAbstract !== "") newComponentUri += "/" + component.uriAbstract;

                appHistory.pushState(newComponentUri, "component", component.instanceId, component.parentInstanceId);
            }
            else if (vcType === "hub")
            {
                if (typeof component.uriAbstract !== "undefined") {
                    let newComponentUri = (typeof uriBasePath !== "undefined" ? ("/" + uriBasePath) : "") + "/" + component.uriAbstract;
                    appHistory.pushState(newComponentUri, "component", component.instanceId, component.parentInstanceId);
                }
            }
            slideComponentsBack(callback)
        }
    }

    const runAsyncUriUpdate = function(newComponentUri, component)
    {
        if (typeof component.instance.entity.card_num === "undefined")
        {
            setTimeout(function() {
                //ezLog(component.instance.entity, "InstanceEntity")
                runAsyncUriUpdate(newComponentUri, component)
            },100);
            return;
        }

        if (component.instance.entity.card_vanity_url)
        {
            newComponentUri = newComponentUri.replace("{card_num}", component.instance.entity.card_vanity_url);
        }
        else
        {
            newComponentUri = newComponentUri.replace("{card_num}", component.instance.entity.card_num);
        }

        appHistory.pushState(newComponentUri, "component", component.instanceId, component.parentInstanceId);
    }

    this.registerModalByRef = function(modal)
    {
        _.modal = modal.$children[0];
    }

    const setParentId = function(component)
    {
        componentParentId = null;

        if (component.parentInstanceId)
        {
            componentParentId = component.parentInstanceId;
        }
    }

    this.setTitle = function(title)
    {
        _.vue.modal_title = title;
        return _;
    }

    this.showModal = function(vueComponent, callback)
    {
        if (typeof vueComponent !== "undefined")
        {
            let component = _.getComponentByInstanceId(vueComponent.instanceId);
            this.loadComponentByInstance(component, true, true, callback);
            return;
        }

        _.vue.showModal = true;
        return _;
    }

	const showComponent = function(methodCall, returning)
	{
	    if (typeof _.vue.show !== "undefined")
        {
            _.vue.show(currentComponentId);
        }

		let component = _.getComponentByInstanceId(currentComponentId);

	    if (component === null) {
	        console.log("ShowComponent unable to find component by InstanceId: " + currentComponentId)
	        return;
        }

		if (!returning)
        {
            setParentId(component);
        }

		let componentEl =  document.getElementById(currentComponentId);

        if (componentEl === null) return;

        toggleNewComponent(componentEl, component, currentComponentId, componentParentId, function ()
        {
            let componentTitle = buildComponentTitle(component, componentAction);
            _.vue.modal_title = componentTitle;

            if (vcType === "modal")
            {
                _.vue.setWidth(component.modalWidth);
            }

            // update breadCrumb
            updateBreadCrumb(component);
            updateSubPageLinks(component);

            if (returning)
            {
                setParentId(component);
            }

            if (
                typeof component.instance !== "undefined" &&
                component.instance !== null &&
                typeof component.instance.showComponent !== "undefined"
            )
            {
                component.instance.showComponent();

                if(methodCall)
                {
                    if (typeof component.instance[methodCall] === "function")
                    {
                        component.instance[methodCall]();
                    }
                }
            }

            _.vue.$forceUpdate();

            addResizeSensorToReadyClient();
        });
	}

	const updateBreadCrumb = function(component)
    {
        if (vcType !== "app") { return; }

        if (typeof _.vue.renderBreadCrumb === "function")
        {
            _.vue.renderBreadCrumb(component.instance);
        }
    }

	const updateSubPageLinks = function(component)
    {
        if (vcType !== "app") { return; }

        if (typeof _.vue.renderSubPageLinks === "function")
        {
            _.vue.renderSubPageLinks(component.instance);
        }
    }

	const addResizeSensorToReadyClient = function()
    {
        if (_.el.clientWidth === 0)
        {
            setTimeout(function()
            {
                addResizeSensorToReadyClient();

            }, 10);
            return;
        }

        addResizeSensor();
    }

	const addResizeSensor = function()
    {
        if (resizeSensor === null)
        {
            resizeSensor = new ResizeSensorFromSO(_.el, function() {
                resizeComponents();
            });
        }

        resizeComponents();
    }

    const resizeComponents = function()
    {
        componentWidth = _.el.clientWidth;
        let components = getComponentsDomInstances();

        for (let currClassIndex = 0; currClassIndex < components.length; currClassIndex++)
        {
            components[currClassIndex].style.width = componentWidth + "px";
        }

        document.documentElement.style.setProperty('--vh', `${window.innerHeight}px`);
        document.documentElement.style.setProperty('--vhw1', `${window.innerHeight-90}px`);
    }

	const createComponentNode = function(instanceId, componentInstance)
	{
        if (componentInstance.mountType !== "default" && typeof componentInstance.mountType !== "undefined") return null;

        const componentId = "a" + instanceId.replace(/-/g,"");
		const componentSubId = "sub_" + instanceId.replace(/-/g,"");

		const node = document.createElement("div");
		node.id = instanceId;
		node.classList.add("vue-app-body-component");

		if (!vcType)
        {
            node.classList.add("formwrapper-control");
        }

		let componentNode = "<" + componentId + " id=\"" + componentSubId + "\"";
		componentNode += "></" + componentId + ">";

		node.innerHTML = componentNode;
        node.style.display = "none";

        vueWrapper.appendChild(node);

		return componentSubId;
	}

	this.hideComponents = function()
	{
        let components = getComponentsDomInstances();

		for (let currClassIndex = 0; currClassIndex < components.length; currClassIndex++)
		{
			components[currClassIndex].style.display = "none";
		}
	}

	const getComponentsDomInstances = function()
    {
        let getElChildren = "#" + elId + ">.vue-modal-wrapper>div";

        let components = document.querySelectorAll(getElChildren);

        if (components.length === 0) getElChildren = "#" + elId + ">#vue-app-body-custom>.vue-modal-wrapper>div";

        return document.querySelectorAll(getElChildren);
    }

    this.getIdFromUriAbstract = function(pattern, abstract)
    {
        const abstractMatch = abstract.split("/");
        const patternMatch = pattern.split("/");

        for (let currMapIndex in patternMatch)
        {
            if (patternMatch[currMapIndex].substring(0,1) === "{" && patternMatch[currMapIndex].slice(-1) === "}")
            {
                if (patternMatch[currMapIndex] === "{id}")
                {
                    return abstractMatch[currMapIndex];
                }

                continue;
            }

            if ( patternMatch[currMapIndex] === abstractMatch[currMapIndex])
            {
                continue;
            }

            return null;
        }

        return null;
    }

	this.buildComponent = function(component)
	{
		if (typeof component.instance !== "undefined" && typeof component.instance.$children !== "undefined")
		{
			const childInstance = component.instance.$children[0];
			component.instance = childInstance;
		}

		return component;
	}

	this.hydrate = function(instanceId, parentInstanceId, action, entity, entities, props, show)
    {
        hydrateComponent(instanceId, parentInstanceId, action, entity, entities, props, show)
    }

	const hydrateComponent = function(instanceId, parentInstanceId, action, entity, entities, props, show)
	{
		let component = _.getComponentByInstanceId(instanceId);

		if (
			typeof component.instance === "undefined" ||
			component.instance === null ||
			typeof component.instance.hydrateComponent === "undefined"
		)
		{
			//console.log(instanceId + " component cannot be hydrated");
			return;
		}

        _.vue.modal_title = buildComponentTitle(component, action);
		componentAction = action;

		toggleComponentParent(component, parentInstanceId);

		component.instance
            .setModalComponentInstance(component.instanceId, show)
            .injectDefaultData(component.instanceId, component.parentInstanceId, action, entity, entities, props,  _.parentData, userId, userNum)
            .hydrateComponent(props, show, function(self) { self.$forceUpdate(); });
	}

	const toggleComponentParent = function(component, parentInstanceId)
    {
        if (parentInstanceId === '')
        {
            component.disableParent = true;
            return;
        }

        component.disableParent = false;
    }

	const buildComponentTitle = function(component, action)
	{
		let componentTitle = "";

        if (typeof component.instance === "undefined") return componentTitle;

		switch(action)
		{
			case "add": componentTitle = "Add Entity"; break;
			case "edit": componentTitle = "Edit Entity"; break;
			case "delete": componentTitle = "Delete Entity"; break;
			case "read": componentTitle = "View Entity"; break;
		}

		if (typeof component.instance.getModalTitle === "function")
		{
			let componentTitleTemp = component.instance.getModalTitle(action);

			if (componentTitleTemp !== null && componentTitleTemp !== "")
			{
				componentTitle = componentTitleTemp;
			}
		}

		return componentTitle;
	}

	const assignExpectedRootMethods = function(helper)
	{
		if (typeof helper.dynamicComponents === "function")
		{
			helper.methods.dynamicComponents = helper.dynamicComponents;
			helper.dynamicComponents = null;
		}
	}

	this.setInitialComponentLoad = function()
    {
        initialComponentLoad = true;
    }


	this.getInitialComponentLoad = function()
    {
        return initialComponentLoad;
    }

    function ResizeSensorFromSO(element, callback) {
        let zIndex = parseInt(getComputedStyle(element))
        if (isNaN(zIndex)) {
            zIndex = 0
        }
        zIndex--

        let expand = document.createElement('div')
        expand.style.position = "absolute"
        expand.style.left = "0px"
        expand.style.top = "0px"
        expand.style.right = "0px"
        expand.style.bottom = "0px"
        expand.style.overflow = "hidden"
        expand.style.zIndex = zIndex
        expand.style.visibility = "hidden"

        let expandChild = document.createElement('div')
        expandChild.style.position = "absolute"
        expandChild.style.left = "0px"
        expandChild.style.top = "0px"
        expandChild.style.width = "10000000px"
        expandChild.style.height = "10000000px"
        expand.appendChild(expandChild)

        let shrink = document.createElement('div')
        shrink.style.position = "absolute"
        shrink.style.left = "0px"
        shrink.style.top = "0px"
        shrink.style.right = "0px"
        shrink.style.bottom = "0px"
        shrink.style.overflow = "hidden"
        shrink.style.zIndex = zIndex
        shrink.style.visibility = "hidden"

        let shrinkChild = document.createElement('div')
        shrinkChild.style.position = "absolute"
        shrinkChild.style.left = "0px"
        shrinkChild.style.top = "0px"
        shrinkChild.style.width = "200%"
        shrinkChild.style.height = "200%"
        shrink.appendChild(shrinkChild)

        element.appendChild(expand)
        element.appendChild(shrink)

        function setScroll()
        {
            expand.scrollLeft = 10000000
            expand.scrollTop = 10000000

            shrink.scrollLeft = 10000000
            shrink.scrollTop = 10000000
        }

        setScroll()

        let size = element.getBoundingClientRect()

        let currentWidth = size.width
        let currentHeight = size.height

        function processMediaQuery(windowWidth,bodyEl,comTag)
        {
            bodyEl.classList.remove("media-"+comTag+"-320")
            bodyEl.classList.remove("media-"+comTag+"-400")
            bodyEl.classList.remove("media-"+comTag+"-480")
            bodyEl.classList.remove("media-"+comTag+"-568")
            bodyEl.classList.remove("media-"+comTag+"-640")
            bodyEl.classList.remove("media-"+comTag+"-768")
            bodyEl.classList.remove("media-"+comTag+"-850")
            bodyEl.classList.remove("media-"+comTag+"-1024")
            bodyEl.classList.remove("media-"+comTag+"-1224")
            bodyEl.classList.remove("media-"+comTag+"-1300")

            let classClass = ""
            if (windowWidth <= 1300) classClass = "media-"+comTag+"-1300"
            if (windowWidth <= 1224) classClass = "media-"+comTag+"-1224"
            if (windowWidth <= 1024) classClass = "media-"+comTag+"-1024"
            if (windowWidth <= 850) classClass = "media-"+comTag+"-850"
            if (windowWidth <= 768) classClass = "media-"+comTag+"-768"
            if (windowWidth <= 640) classClass = "media-"+comTag+"-640"
            if (windowWidth <= 568) classClass = "media-"+comTag+"-568"
            if (windowWidth <= 480) classClass = "media-"+comTag+"-480"
            if (windowWidth <= 400) classClass = "media-"+comTag+"-400"
            if (windowWidth <= 320) classClass = "media-"+comTag+"-320"

            if (classClass !== "") {
                bodyEl.classList.add(classClass)
            }
            dispatch.broadcast("screen_resize", {width: windowWidth})
        }

        let onScroll = function()
        {
            let size = element.getBoundingClientRect()

            let newWidth = size.width
            let newHeight = size.height

            if (newWidth !== currentWidth || newHeight !== currentHeight) {
                currentWidth = newWidth
                currentHeight = newHeight

                // We need to check and see what the declaration is, and if it's empty, run these.
                const windowWidth = window.innerWidth
                let bodyEl = _.el
                let comTag = "app"

                if( _.el.id.includes("vue-hub-body")) {
                    comTag = "hub"
                }

                processMediaQuery(windowWidth,bodyEl,comTag)

                callback()
            }

            setScroll()
        }

        expand.addEventListener('scroll', onScroll)
        shrink.addEventListener('scroll', onScroll)
    }

    const resolveCamelCase = function(string)
	{
		if (!string || string === "" || typeof string !== "string") { return string }
		return string.split(/(?=[A-Z])/).join("-").toLowerCase()
	}

	const uuidv4 = function ()
	{
		return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
			(c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
		);
	}

    this.isVcModal = function()
    {
        return vcType == "modal";
    }

    this.setType = function(type)
    {
        vcType = type;
    }

    this.getType = function()
    {
        return vcType;
    }

	this.addAjaxClass = function()
	{
		let bodyDialogBox = document.getElementsByClassName("zgpopup-dialog-body")
		if (typeof bodyDialogBox[bodyDialogBox.length - 1] === "undefined") { return }
		bodyDialogBox[bodyDialogBox.length - 1].classList.add("ajax-loading-anim")
        _.vue.$forceUpdate()
	}

	this.removeAjaxClass = function()
	{
		let bodyDialogBox = document.getElementsByClassName("zgpopup-dialog-body")
        if (typeof bodyDialogBox[bodyDialogBox.length - 1] === "undefined") { return }
		bodyDialogBox[bodyDialogBox.length - 1].classList.remove("ajax-loading-anim")
        _.vue.$forceUpdate()
	}

	__construct()
}

