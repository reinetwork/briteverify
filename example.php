<?php
include 'vendor/autoload.php';

$client = new REINetwork\BriteVerify\Client('26198378-8fd2-4af9-8a9e-9c45422c8d91');

echo "<div style='clear: both; padding: 10px; margin: 10px; border: 1px solid blue;'><pre><p>".__METHOD__. ":" .__LINE__."</p>";
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', 250);
ini_set('xdebug.var_display_max_depth', 15);
//debug_print_backtrace();
var_dump($client->verify('fake@email-wrong.com'));
//echo '<hr/>';
//var_dump();
//echo '<hr/>';
echo "</pre></div>";die;

