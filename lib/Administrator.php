<?php

class Administrator {

	private $name;
	private $role_id;
	private $phone;
	private $email;
	private $password;
	private $image_link;
	
	function __construct($name, $role_id, $phone, $email, $password, $image_link, $id = null) {
		$this->name = trim(ucfirst(strtolower($name)));
		$this->phone = trim($phone);
		if ($role_id !== 1) {
			$this->role_id = (int)$role_id; //creating an owner is blocked :)
		}
		$this->email = trim($email);
		$this->password = password_hash($password, PASSWORD_DEFAULT);
		$this->image_link = $image_link;
		if (!is_null($id)) {
			$this->id = $id;
		}
	}

	public function save() {
		$stmt = DB::getConnection()->prepare("
			INSERT INTO administrators (name, role_id, phone, email, password, image_link)
			VALUES (:name, :role_id, :phone, :email, :password, :image_link)
		");
		$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
		$stmt->bindParam(':phone', $this->phone, PDO::PARAM_STR);
		$stmt->bindParam(':role_id', $this->role_id, PDO::PARAM_INT);
		$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
		$stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
		$stmt->bindParam(':image_link', $this->image_link, PDO::PARAM_STR);
		$stmt->execute();
		$id = DB::getConnection()->lastInsertId();
		$this->id = $id;

		return $id;
	}

	public function validateAdmin($email, $password) {
		$stmt = DB::getConnection()->prepare("
			SELECT *
			FROM administrators
			WHERE email = :email
			LIMIT 1
		");
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch();
		if ($result) {
			if (password_verify($password, $result['password'])) {
				session_start();
                $_SESSION['admin_id'] = $result['id'];
                $_SESSION['admin_role_id'] = $result['role_id'];
                return true;
			}
		}
	}

	public static function getAll() {
		return DB::getConnection()->query("
			SELECT a.id,
				   a.name,
				   a.phone,
				   a.role_id,
				   a.email,
				   a.password,
				   a.image_link,
				   r.role
			FROM administrators a 
			JOIN roles r ON a.role_id = r.id
		");
	}

	public static function getOne($id) {
		$stmt = DB::getConnection()->prepare("
			SELECT a.id,
				   a.name,
				   a.phone,
				   a.role_id,
				   a.email,
				   a.password,
				   a.image_link,
				   r.role
			FROM administrators a 
			JOIN roles r ON a.role_id = r.id
			WHERE a.id = :id
			LIMIT 1
		");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		return $result;
	}

	public function update($name, $email, $phone, $role_id, $image_link, $id) {
		$correct_name = trim(ucfirst(strtolower($name)));
		$stmt = DB::getConnection()->prepare("
			UPDATE administrators 
				SET name = :name, email = :email, phone = :phone, role_id = :role_id, image_link = :image_link
			WHERE id = :id
		");
		$stmt->bindParam(':name', $correct_name, PDO::PARAM_STR);
		$stmt->bindParam(':email', trim($email), PDO::PARAM_STR);
		$stmt->bindParam(':phone', trim($phone), PDO::PARAM_STR);
		$stmt->bindParam(':role_id', $role_id, PDO::PARAM_STR);
		$stmt->bindParam(':image_link', $image_link, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		
		if ($stmt->errorCode() !== '00000') {
			die($stmt->errorInfo()[0]);
		}
	}

	public function delete($id) {
		if ($id !== 1) { //owner cannot get deleted
			$stmt = DB::getConnection()->prepare("
				DELETE FROM administrators
				WHERE id = :id
			");
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
		}
	}

	public static function validateBasicData($name, $phone, $email) {
		$errors = [];
		if (strlen(trim($name)) < 2) {
			$errors['name'] = "The name has to contain at least two letters";
		}
		$phone_validation = preg_match('/^05[0-9]{1}-?[1-9]{1}[0-9]{6}$|^[+]972-?5[0-9]{1}-?[0-9]{7}$/', $phone);
		if ($phone_validation !== 1) {
			$errors['phone'] = "phone has to be an Israeli cellular number such as 052-2224444 or +972-52-2224444 (dashes are not obligatory)";
		}
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
		} else {
			$errors['email'] = "Email address is not correct";
		}
		return $errors;
	}

	public static function validatePassword($password) {
		$password_validation = preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4}$/', $password);
		if ($password_validation === 1) {
			return true;
		} else {
			return false;		
		}
	}

	//private function validatePhone($phone) {
	//	return /^[1-9][0-9]*[.]{0,1}[0-9]*$/.test(num.toString());;
	//}
}