<?php
?>

windowLoad(function(event)
{
    addListener(classListGlobal("excell-mobile-menu"), "click", function(event)
    {
        elm("arc-menu").style.display = "block";
    })
});