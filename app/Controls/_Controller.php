<?php

class BaseControl extends MagratheaController {

  public static function IsLogged() {
    $user = $_SESSION["logged_user"];
    return ($user != null);
  }

  public function CheckLogin() {
    if( !$this->IsLogged() )
      $this->ForwardTo("Login", "Index");
    $this->assign("user", new User($_SESSION["logged_user"]));
  }

  public static function Go404(){
    global $Smarty;
    $Smarty->display("phoenix/error_pages/error_404.html");
    return;
  }

  public static function Kill(){
    global $Smarty;
    $Smarty->display("phoenix/error_pages/error_500.html");
    return;
  }

}
?>
