<?php
class Tools extends CI_Controller
{
    function message($to = 'World')
    {
        echo "Hello {$to}!" . PHP_EOL;
    }
}
