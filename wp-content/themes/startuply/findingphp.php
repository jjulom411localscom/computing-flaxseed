<?php
phpinfo();

function _isCurl(){
    return function_exists('curl_version');
}

if (_iscurl()){
echo "this is enabled"; // will do an action
}else{
echo "this is disabled"; // will do another action
}
?>

