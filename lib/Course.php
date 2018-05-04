<?php
/**
* 
*/
class Course {

	private $name;
	private $description;
	private $image_link;
	
	function __construct($name, $description, $image_link, $id = null) {
		$this->name = $name;
		$this->description = $description;
		$this->image_link = $image_link;
		if (!is_null($id)) {
			$this->id = $id;
		}
	}

	public function save() {
		$stmt = DB::getConnection()->prepare("
			INSERT INTO courses (name, description, image_link)
			VALUES (:name, :description, :image_link)
		");
		$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
		$stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
		$stmt->bindParam(':image_link', $this->image_link, PDO::PARAM_STR);
		$stmt->execute();
		$id = DB::getConnection()->lastInsertId();
		$this->id = $id;

		return $id;
	}

	public function update($name, $description, $image_link, $id) {
		$stmt = DB::getConnection()->prepare("
			UPDATE courses 
			SET name = :name, description = :description, image_link = :image_link
			WHERE id = :id
		");
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':description', $description, PDO::PARAM_STR);
		$stmt->bindParam(':image_link', $image_link, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		
		if ($stmt->errorCode() !== '00000') {
			die($stmt->errorInfo()[0]);
		}
		//if this gives back 00000 it means it works because there are always 5 characters at the first element in the error-info array we get from the system. This is of course not an error but a succesful operation.
	}

	public function delete($id) {
		$stmt = DB::getConnection()->prepare("
			DELETE FROM courses
			WHERE id = :id
		");
		//$stmt->bind_param('sssi', $this->name, $this->color, $this->production_year, $this->id);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	public static function getAll() {
		return DB::getConnection()->query("
			SELECT id, name, description, image_link 
			FROM courses
			");
	}

	public static function GetNamesAndIds() {
		return DB::getConnection()->query("
			SELECT id, name
			FROM courses
		");
	}

	public static function getOne($id) {
		$stmt = DB::getConnection()->prepare("
			SELECT id, name, description, image_link
			FROM courses 
			WHERE id = :id
			LIMIT 1 
		");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		return $result;
	}

	public static function findStudents($id) {
		$stmt = DB::getConnection()->prepare("
			SELECT students.id, students.phone, students.image_link, students.email, students.name
			FROM students
			INNER JOIN enrollment ON students.id = enrollment.student_id
			WHERE enrollment.course_id = :id;
		");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $result;
	}
}