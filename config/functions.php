<?php
function encode($str){
    return htmlspecialchars($str);
}

function page404(){
    header("HTTP/1.1 404 NOt found");
}
