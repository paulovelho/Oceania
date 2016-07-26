<?php

include(__DIR__."/Base/UserBase.php");

class User extends UserBase {
	public function SetPassword($p) {
		$this->password = sha1($p);
		return $this;
	}
}

class UserControl extends UserControlBase {
	public static function Login($email, $password) {
		$query = MagratheaQuery::Select()
			->Obj(new User())
			->Where(array("email" => $email, "password" => sha1($password)));
		return self::RunRow($query);
	}

	public static function SaveSession($user) {
		$_SESSION["logged_user"] = $user->id;
	}
	public static function Logout() {
	}
}

?>