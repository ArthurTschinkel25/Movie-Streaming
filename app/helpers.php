
<?php

if (!function_exists('ddd')) {
    function ddd($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }
}
