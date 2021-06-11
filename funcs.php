<?php
//XSS対応関数
function h($val){
  return htmlspecialchars($val,ENT_QUOTES);
}
function loginCheck(){
  if (!isset($_SESSION["chk_ssid"]) ||$_SESSION["chk_ssid"] != session_id()
  ) {
    echo "LOGIN ERROR";
    echo '<a href="./login.php">Login</a>';
    exit();
  }else{
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
  }
  
}



?>
