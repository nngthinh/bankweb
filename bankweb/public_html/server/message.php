<?php
function raiseSuccess($msg)
{

    return "<div name=\"message\" class=\"success\">$msg</div>";
}

function raiseError($msg)
{
    return "<div name=\"message\" class=\"error\">$msg</div>";
}

function raiseWarning($msg)
{

    return "<div name=\"message\" class=\"warning\">$msg</div>";
}
