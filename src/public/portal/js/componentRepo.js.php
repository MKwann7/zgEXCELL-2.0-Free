const ComponentRepository = function()
{
    const _ = this
    let components = []

    this.register = function(instanceRef, component)
    {
        if (typeof components[instanceRef] === "undefined") components[instanceRef] = []
        components[instanceRef] = component
    }

    this.get = function(instanceRef)
    {
        if (!isIterable(components[instanceRef])) {
            return null
        }

        return components[instanceRef];
    }

    this.getAll = function()
    {
        return components;
    }

    const isIterable = function(obj)
    {
        if (obj == null) {
            return false;
        }

        return typeof obj === 'object';
    }
}

const componentRepo = new ComponentRepository()