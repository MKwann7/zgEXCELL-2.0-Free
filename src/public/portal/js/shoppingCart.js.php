<?php
?>
if (typeof shoppingCart !== "function")
{
    shoppingCart = function()
    {
        const load = function(platformId, elmId)
        {
            sendAjax("<?php echo getFullUrl(); ?>/cart/get-public-cart?id=" + platformId, {}, function (result)
            {
                let dynamicComponent = null;

                try
                {
                    dynamicComponent = new Function(atob(result.widget))();
                }
                catch(ex)
                {
                    alert(ex);
                }

                let dynamicComponentList = [];

                if (typeof dynamicComponent["main"].dynamicComponents === "function")
                {
                    dynamicComponentList = dynamicComponent["main"].dynamicComponents();
                }


                let ComponentClass = Vue.extend(dynamicComponent["main"]);
                let newComponent = new ComponentClass({parent: vueApp}).$mount(document.getElementById(elmId));

                if (dynamicComponentList.length > 0)
                {
                    for (let currComponentId of Array.from(dynamicComponentList))
                    {
                        for (let currHelper of Array.from(dynamicComponent["helpers"]))
                        {
                            if (currHelper["name"] === currComponentId || currHelper["id"] === currComponentId)
                            {
                                newComponent[currComponentId] = currHelper;
                            }
                        }
                    }
                }

                newComponent.hydrateComponent(null, null, "edit", "", [], {directoryId: '123', public: true}, false, "73a0d8b4-57e9-11ea-b088-42010a522005", function(self) {

                });

                newComponent.selectPackagesByClass("card", true);
            });
        }

        const sendAjax = function(url, data, callback)
        {
            console.log(url);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200)
                {
                    if (typeof callback === "function")
                    {
                        callback(JSON.parse(this.responseText));
                    }
                }
            };

            xhttp.open("POST", url, true);
            xhttp.setRequestHeader("Content-type", "application/json;charset=UTF-8");
            xhttp.send(JSON.stringify(data));
        }

        return function(platformId, elmId)
        {
            load(platformId, elmId);
        }
    }();
}
