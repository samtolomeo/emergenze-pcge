<?php

include explode('emergenze-pcge',getcwd())[0]."emergenze-pcge/conn.php";
// current directory
$local_path=explode('emergenze-pcge',getcwd())[0]."emergenze-pcge/conn.php";
require($local_path);

echo $local_path;


?>
