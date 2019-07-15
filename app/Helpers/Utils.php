<?php

function ezReturnErrorMessage($msg)
{

    return array('isError' => true, 'msg' => $msg);

}

function ezReturnSuccessMessage($msg, $data = null, $newRowInserted = null)
{

    $success = array('success' => $msg);

    if ($data) {
        $data = is_object($data) ? $data->toArray() : $data;
        $success = array_merge($success, $data);
    }

    if ($newRowInserted) {
        $success['newRowInserted'] = true;
    }

    return $success;

}

// Function for basic field validation (present and neither empty nor only white space
function isNullOrEmptyString($value)
{
    return (!isset($value) || trim($value) === '');
}
