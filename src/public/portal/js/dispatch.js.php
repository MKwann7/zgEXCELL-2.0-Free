<?php
?>
const Dispatch = function()
{
    const _ = this
    let channels = []
    let events = []

    this.register = function(name, entity, method)
    {
        if (typeof channels[name] === "undefined") channels[name] = []
        channels[name].push(new DispatchChannelRecord(entity, method))
    }

    this.broadcast = function(name, data)
    {
        if (typeof events[name] === "undefined") events[name] = []
        truncateOldEvents(name)
        registerBroadcastEvent(name, data)

        if (!isIterable(channels[name])) {
            return;
        }

        channels[name].forEach(record => {
            record.call(data);
        })
    }

    this.get = function(name) {
        if (!isIterable(events[name]) || typeof events[name][events[name].length-1] === "undefined") {
            return null;
        }

        return events[name][events[name].length-1];
    }

    const registerBroadcastEvent = function(name, data) {
        events[name].push(data)
    }

    const truncateOldEvents = function(name) {
        if (events[name].length > 5) {
            events[name].splice(events[name].length-1, 1)
        }
    }

    const isIterable = function(obj)
    {
        if (obj == null)
        {
            return false;
        }

        return typeof obj[Symbol.iterator] === 'function';
    }
}

const DispatchChannelRecord = function(entity, method)
{
    const _ = this
    let recordEntity;
    let recordMethod;

    const __construct = function(entity, method)
    {
        recordEntity = entity
        recordMethod = method
    }

    this.call = function(data)
    {
        if (typeof recordEntity[recordMethod] === "function") {
            recordEntity[recordMethod](data)
        }
    }

    __construct(entity, method)
}

dispatch = new Dispatch()