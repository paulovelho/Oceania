<?php

class BaseControl extends MagratheaController {

  public static function IsLogged() {
    $user = $_SESSION["logged_user"];
    return ($user != null);
  }

  protected function LoadStatus() {
    $status = Statuses::GetAll();
    $st = array();
    foreach ($status as $s) {
      $st[$s->id] = $s->name;
    }
    $this->assign("status", $st);
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
