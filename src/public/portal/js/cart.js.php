<?php
?>
const AppCart = function(cartVueWidget)
{
    const _ = this;
    const packageList = [];
    let vue = null

    const __construct = function(cartVueWidget)
    {
        vue = cartVueWidget;
    }

    this.openPackagesByClass = function(name, parentEntity, userId)
    {
        vue.selectPackagesByClass(name, false, parentEntity, userId)
        return _;
    }

    this.registerEntityListAndManager = function(listId, managerId)
    {
        vue.registerEntityListAndManager(listId, managerId)
        return _;
    }

    this.openCart = function(options)
    {
        vue.openCart(options)
    }

    this.addPackageToCart = function(id)
    {
        ajax.Send("/cart/get-package?id=" + id, {}, function() {

        });
    }

    __construct(cartVueWidget);
}
