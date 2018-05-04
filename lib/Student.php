<?php
/**
* 
*/
class Student {

	private $name;
	private $phone;
	private $email;
	private $image_link;
	
	function __construct($name, $phone, $email, $image_link, $id = null) {
		$this->name = trim(ucfirst(strtolower($name)));
		$this->phone = trim($phone);
		$this->email = trim($email);
		$this->image_link = $image_link;
		if (!is_null($id)) {
			$this->id = $id;
		}
	}

	public function save() {
		$stmt = DB::getConnection()->prepare("
			INSERT INTO students (name, phone, email, image_link)
			VALUES (:name, :phone, :email, :image_link)
		");
		$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
		$stmt->bindParam(':phone', $this->phone, PDO::PARAM_STR);
		$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
		$stmt->bindParam(':image_link', $this->image_link, PDO::PARAM_STR);
		$stmt->execute();
		$id = DB::getConnection()->lastInsertId();
		$this->id = $id;

		return $id;
	}

	public static function getAll() {
		return DB::getConnection()->query("
			SELECT id, name, phone, email, image_link 
			FROM students
			");
	}
	public static function getOne($id) {
		$stmt = DB::getConnection()->prepare("
			SELECT id, name, phone, email, image_link
			FROM students 
			WHERE id = :id
			LIMIT 1 
		");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();

		return $result;
	}

	public static function enroll($chosen_course_id, $chosen_student_id) {
		$stmt = DB::getConnection()->prepare("
			INSERT INTO enrollment (course_id, student_id)
			VALUES (:chosen_course_id, :chosen_student_id)
		");
		$stmt->bindParam(':chosen_course_id', $chosen_course_id, PDO::PARAM_INT);
		$stmt->bindParam(':chosen_student_id', $chosen_student_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	public static function deleteEnrollment ($chosen_course_id, $chosen_student_id) {
		$stmt = DB::getConnection()->prepare("
			DELETE FROM enrollment
			WHERE course_id = :chosen_course_id AND student_id = :chosen_student_id
		");
		//$stmt->bind_param('sssi', $this->name, $this->color, $this->production_year, $this->id);
		$stmt->bindParam(':chosen_course_id', $chosen_course_id, PDO::PARAM_INT);
		$stmt->bindParam(':chosen_student_id', $chosen_student_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function update($name, $phone, $email, $image_link, $id) {
		$correct_name = trim(ucfirst(strtolower($name)));
		$stmt = DB::getConnection()->prepare("
			UPDATE students 
				SET name = :name, phone = :phone, email = :email, image_link = :image_link
			WHERE id = :id
		");
		$stmt->bindParam(':name', $correct_name, PDO::PARAM_STR);
		$stmt->bindParam(':phone', trim($phone), PDO::PARAM_STR);
		$stmt->bindParam(':email', trim($email), PDO::PARAM_STR);
		$stmt->bindParam(':image_link', $image_link, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		
		if ($stmt->errorCode() !== '00000') {
			die($stmt->errorInfo()[0]);
		}
	}

	public function delete($id) {
		$stmt = DB::getConnection()->prepare("
			DELETE FROM students
			WHERE id = :id
		");
		//$stmt->bind_param('sssi', $this->name, $this->color, $this->production_year, $this->id);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	//public static function findCourses($id) {
	//	$stmt = DB::getConnection()->prepare("
	//		SELECT enrollment.course_id
	//		FROM students
	//		INNER JOIN enrollment ON students.id = enrollment.student_id
	//		WHERE students.id = :id;
	//	");
	//	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	//	$stmt->execute();
	//	$result = $stmt->fetchAll();

	//	return $result;
	//}

	public static function findCourses($student_id) {
		$stmt = DB::getConnection()->prepare("
			SELECT courses.id, courses.name, courses.image_link
			FROM courses
			INNER JOIN enrollment ON courses.id = enrollment.course_id
			WHERE enrollment.student_id = :id;
		");
		$stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $result;
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
}