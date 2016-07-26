<?php

class LoginController extends BaseControl {

	private function Start() {
		$this->assign("page_title", "Login");
	}

	public function Index(){
		$this->Start();
		$this->display("phoenix/login.html");
	}

	public function Go() {
		$email = @$_POST["username"];
		$password = @$_POST["password"];
		if( empty($email) || empty($password) ) return $this->Index();

		$user = UserControl::Login($email, $password);

		if($user == null) {
			$this->assign("message", "User Invalid");
			return $this->Index();
		} else {
			UserControl::SaveSession($user);
			$this->ForwardTo("Home");
		}
	}

	public function Out() {
		UserControl::Logout();
		session_unset();
		$this->ForwardTo("Login");
	}

}

?>
