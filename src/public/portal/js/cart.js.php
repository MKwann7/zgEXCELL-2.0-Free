<?php
?>
const AppCart = function(cartVueWidget)
{
    const _ = this;
    const packageList = [];
    let vue = null

    const __construct = function(cartVueWidget)
    {
        vue = cartVueWidget
    }

    this.openPackagesByClass = function(name, parentEntity, customerId, userId)
    {
        vue.selectPackagesByClass(name, false, parentEntity, customerId, userId)
        return _
    }

    this.openCart = function(parentEntity, public)
    {
        vue.assignParentEntityToCartById(parentEntity)
        vue.openCart({}, public)
        return _
    }

    this.openAssignUser = function(parentEntity)
    {
        vue.assignParentEntityToCartById(parentEntity)
        vue.openAssignUser(false)
        return _
    }

    this.addPackageToCart = function(packageId)
    {
        vue.addPackageToCartById(packageId)
        return _
    }

    this.setCartPrivacy = function(logical)
    {
        vue.setCartPrivacy(logical)
        return _
    }

    this.registerEntityListAndManager = function(listId, managerId)
    {
        if (!listId) return _
        vue.registerEntityListAndManager(listId, managerId)
        return _
    }

    this.setCustomerByUuid = function(uuid)
    {
        if (uuid === null) return;

        vue.registerCustomerByUuid(uuid)
        return _
    }

    __construct(cartVueWidget);
}
