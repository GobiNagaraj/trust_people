<?php
// get the q parameter from URL
$q = $_REQUEST["q"];
//Checks if the URL has "www.linkedin.com" for validation
if ($q !== "") {
    $q = strtolower($q);
    if (strpos($q, 'www.linkedin.com') !== false) {
        echo '<span class="col-25" style="color:green;">Valid URL</span>';
    }else{
        echo '<span class="col-25 "style="color:red;">Invalid URL</span>';
    }
}
?>