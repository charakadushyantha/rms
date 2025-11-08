<?php
echo "Rewrite test page loaded successfully!<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";
phpinfo(INFO_MODULES);
?>
