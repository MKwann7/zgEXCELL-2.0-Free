<?php
?>
const AppHistory = function()
{
    const _ = this;

    const __construct = function()
    {
        const uriFullPath = getCurrentPath();
        const currentHistory = _.getCurrentHistory();

        //console.log(uriFullPath);

        if (typeof currentHistory === "undefined" || currentHistory === null)
        {
            _.replaceState(uriFullPath, "page");
        }
        else if (uriFullPath !== currentHistory.path)
        {
            // moving forward
            _.pushState(uriFullPath, "page");
        }

        window.onpopstate = function(event)
        {
            processStateChange(event.state);
        }
    }

    const getCurrentPath = function()
    {
        const uriPath = window.location.pathname;
        const objUri = window.location.href.split(uriPath);
        return uriPath + objUri[1];
    }

    const processStateChange = function(state)
    {
        const uriFullPath = getCurrentPath();
        const intHistryId = state.index ?? 1;
        const objHistory = getHistoryById(intHistryId);

        if (objHistory === null) {
            console.log("processStateChange History Id [" + intHistryId + "] not found.");
            return;
        }

        const currentHistory = _.getCurrentHistory();

        if (parseFloat(currentHistory.index) > parseFloat(state.index))
        {
            setNewCurrentPageIndex(state.index);
            //console.log(objHistory);
            vueApplication.loadPageByUri(uriFullPath);
            return;
        }
        else if (parseFloat(currentHistory.index) < parseFloat(state.index))
        {
            setNewCurrentPageIndex(state.index);
            //console.log(objHistory);
            vueApplication.loadPageByUri(uriFullPath);
            return;
        }

        //console.log("page refresh");
    }

    const saveState = function(uri, index, type, instanceId, parentId)
    {
        let objHistory = getHistory();

        const objPath = {
            index: index,
            path: uri,
            type: type,
            instanceId: instanceId,
            parentId: parentId,
        };

        if (objHistory.length >= parseFloat(index - 1))
        {
            objHistory = objHistory.slice(0, index - 1);
        }


        //console.log("saveState!")
        //console.log(objPath)

        objHistory.push(objPath);
        sessionStorage.setItem('history', JSON.stringify(objHistory));

        return objPath;
    }

    this.updateCurrentHistory = function(instanceId, parentId, path)
    {
        let currentHistory = _.getCurrentHistory();

        if (typeof path !== "undefined")
        {
            currentHistory.path = path;
        }

        if (typeof parentId !== "undefined")
        {
            currentHistory.parentId = parentId;
        }

        currentHistory.instanceId = instanceId;

        let objHistory = getHistory();

        let currentHistoryIndex = 0;

        for (let currHistoryIndex in objHistory)
        {
            if (objHistory[currHistoryIndex].index === currentHistory.index)
            {
                currentHistoryIndex = currHistoryIndex;
                break;
            }
        }

        objHistory[currentHistoryIndex] = currentHistory;

        //console.log(currentHistory);
        //console.log(objHistory);

        sessionStorage.setItem('history', JSON.stringify(objHistory));
    }

    const getHistoryById = function(index)
    {
        if(!index) index = 1;
        const objHistory = getHistory();

        for(let currHistory of objHistory)
        {
            if (parseFloat(currHistory.index) === parseFloat(index)) return currHistory;
        }

        return null;
    }

    const getHistory = function()
    {
        let objHistory = sessionStorage.getItem('history');

        if (objHistory === null) { objHistory = []; }

        if (typeof objHistory === "string") {
            if (objHistory === "") { objHistory = []; }
            else { objHistory = JSON.parse(objHistory); }
        }

        return objHistory;
    }

    this.getCurrentHistory = function()
    {
        const index = getCurrentPageIndex();
        return getHistoryById(index);
    }

    this.pushState = function(uri, type, instanceId, parentId)
    {
        const objHistory = _.getCurrentHistory();

        if (objHistory.path === uri)
        {
            // page refresh
            return;
        }
        const index = getCurrentPageIndex();
        const objPath = saveState(uri, (index + 1), type, instanceId, parentId);
        const urlData = {
            index: objPath.index,
        };
        history.pushState(urlData, "", uri);

        setNewCurrentPageIndex(objPath.index);

        return objPath.index;
    }

    this.replaceState = function(uri, type, instanceId, parentId)
    {
        const index = getCurrentPageIndex();
        const objPath = saveState(uri, index, type, instanceId, parentId);
        history.replaceState({index: objPath.index}, "", uri);

        setNewCurrentPageIndex(objPath.index);

        return objPath.index;
    }

    const setNewCurrentPageIndex = function(index)
    {
        sessionStorage.setItem('currentPageIndex', index);
    }

    const getCurrentPageIndex = function()
    {
        const currentPageIndex = sessionStorage.getItem('currentPageIndex');

        if (typeof currentPageIndex === "undefined" || currentPageIndex === null)
        {
            return 1;
        }

        return parseFloat(currentPageIndex);
    }

    __construct();
}

const appHistory = new AppHistory();
