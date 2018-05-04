<?php 

require 'lib/DB.php';
require 'lib/Administrator.php';
require 'lib/Course.php';
require 'lib/Student.php';

$app->get('/login', function ($request, $response) {
	session_start();
	if (isset($_SESSION['error'])) {
		$error = $_SESSION['error'];
		session_destroy();
		return $this->view->render($response, 'login.html', [
			'error' => $error
		]);
	} else {
		unset($_SESSION['error']);
		return $this->view->render($response, 'login.html', [
	]);
	}
});

$app->post('/check-login', function ($request, $response, $args) {
	$body = $request->getParsedBody();
	$email = $body['email'];
	$password = $body['psw'];
	if (Administrator::validateAdmin($email, $password)) {
		return $response->withRedirect('/home');
	} else {
		session_start();
		$_SESSION['error'] = "Email and/or password are incorrect";
		return $response->withRedirect('/login');
	}
});

$app->get('/logout', function ($request, $response) {
	session_start();
	if (isset($_SESSION['admin_id'])) {
		session_destroy();
	}
	return $response->withRedirect('/login');
});

$app->get('/home', function ($request, $response) {
	session_start();
	//var_dump($_SESSION['admin_id']);
	if (isset($_SESSION['admin_id'])) {
		$courses = Course::getAll();
		$students = Student::getAll();
		$admin = Administrator::getOne($_SESSION['admin_id']);
		return $this->view->render($response, 'home.html', [
			'courses' => $courses,
			'students' => $students,
			'admin' => $admin
		]);
	} else {
		return $response->withRedirect('/login');
	}
});

$app->get('/administrator-home', function ($request, $response) {
	session_start();
	//var_dump($_SESSION['admin_id']);
	if (isset($_SESSION['admin_id'])) {
		if ($_SESSION['admin_role_id'] === 3) {
			return $response->withRedirect('/home');
		} else {
			$admin = Administrator::getOne($_SESSION['admin_id']);
			$administrators = Administrator::getAll();
			return $this->view->render($response, 'administrator_home.html', [
				'administrators' => $administrators,
				'admin' => $admin
		]);

		}
	} else {
		return $response->withRedirect('/login');
	}
});

$app->get('/course/{course_id:\d+}', function ($request, $response, $args) {
	session_start();
	//var_dump($_SESSION['admin_id']);
	if (isset($_SESSION['admin_id'])) {
		$admin = Administrator::getOne($_SESSION['admin_id']);
		$course_id = $args['course_id'];
		$specific_course = Course::getOne($course_id);
		$courses = Course::getAll();
		$students = Student::getAll();
		$students_in_course = Course::findStudents($course_id);
		$count = count($students_in_course);
		return $this->view->render($response, 'course.html', [
			'admin' => $admin,
			'specific_course' => $specific_course,
			'courses' => $courses,
			'students' => $students,
			'count' => $count,
			'students_in_course' => $students_in_course
		]);
	} else {
		return $response->withRedirect('/login');
	}
});

$app->get('/administrator/{administrator_id:\d+}', function ($request, $response, $args) {
	session_start();
	if (isset($_SESSION['admin_id'])) {
		if ($_SESSION['admin_role_id'] === 3) { //sales has no access
			return $response->withRedirect('/home');
		}
		$administrator_id = $args['administrator_id'];
		$specific_administrator = Administrator::getOne($administrator_id);
		if ($_SESSION['admin_role_id'] == 2 && $specific_administrator['role_id'] == 1) {
			//if a manager(role_id: 2) is connected he has no access to the owner's info
			return $response->withRedirect('/administrator-home');
		} else { 
			$administrators = Administrator::getAll();
			$admin = Administrator::getOne($_SESSION['admin_id']);
			return $this->view->render($response, 'administrator.html', [
				'administrators' => $administrators,
				'admin' => $admin,
				'specific_administrator' => $specific_administrator
			]);
		}
	} else {
		return $response->withRedirect('/login');
	}
});

$app->get('/administrator/edit/{administrator_id:\d+}', function ($request, $response, $args) {
	session_start();
	//var_dump($_SESSION['admin_id']);
	if (isset($_SESSION['admin_id'])) {
		if ($_SESSION['admin_role_id'] === 3) { //sales has no access
			return $response->withRedirect('/home');
		}
		$admin = Administrator::getOne($_SESSION['admin_id']);
		$administrator_id = $args['administrator_id'];
		$specific_administrator = administrator::getOne($administrator_id);
		$administrators = Administrator::getAll();
		return $this->view->render($response, 'administrator_edit.html', [
			'administrators' => $administrators,
			'admin' => $admin,
			'specific_administrator' => $specific_administrator
		]);
	} else {
		return $response->withRedirect('/login');
	}
});

$app->get('/student/{student_id:\d+}', function ($request, $response, $args) {
	session_start();
	//var_dump($_SESSION['admin_id']);
	if (isset($_SESSION['admin_id'])) {
		$admin = Administrator::getOne($_SESSION['admin_id']);
		$student_id = $args['student_id'];
		$specific_student = Student::getOne($student_id);
		$courses = Course::getAll();
		$students = Student::getAll();
		$checkbox_info = Course::GetNamesAndIds();
		$signed_to = Student::findCourses($student_id);
		return $this->view->render($response, 'student.html', [
			'admin' => $admin,
			'specific_student' => $specific_student,
			'courses' => $courses,
			'students' => $students,
			'signed_to' => $signed_to,
			'checkbox_info' => $checkbox_info
		]);
	} else {
		return $response->withRedirect('/login');
	}
});

$app->get('/student/edit/{student_id:\d+}', function ($request, $response, $args) {
	session_start();
	//var_dump($_SESSION['admin_id']);
	if (isset($_SESSION['admin_id'])) {
		$admin = Administrator::getOne($_SESSION['admin_id']);
		$student_id = $args['student_id'];
		$specific_student = Student::getOne($student_id);
		$courses = Course::getAll();
		$checkbox_info = Course::GetNamesAndIds();
		$students = Student::getAll();
		$signed_to = Student::findCourses($student_id);
		return $this->view->render($response, 'student_edit.html', [
			'admin' => $admin,
			'specific_student' => $specific_student,
			'courses' => $courses,
			'students' => $students,
			'signed_to' => $signed_to,
			'checkbox_info' => $checkbox_info
		]);
	} else {
		return $response->withRedirect('/login');
	}
}); 

$app->get('/course/edit/{course_id:\d+}', function ($request, $response, $args) {
	session_start();
	//var_dump($_SESSION['admin_id']);
	if (isset($_SESSION['admin_id'])) {
		if ($_SESSION['admin_role_id'] === 3) { //sales has no access
			return $response->withRedirect('/home');
		}
		$admin = Administrator::getOne($_SESSION['admin_id']);
		$course_id = $args['course_id'];
		$specific_course = Course::getOne($course_id);
		$courses = Course::getAll();
		$students = Student::getAll();
		$students_in_course = Course::findStudents($course_id);
		$count = count($students_in_course);
		$copied_courses = $courses;
		return $this->view->render($response, 'course_edit.html', [
			'admin' => $admin,
			'specific_course' => $specific_course,
			'courses' => $courses,
			'students' => $students,
			'students_in_course' => $students_in_course,
			'count' => $count,
			'copied_courses' => $copied_courses
		]);
	} else {
		return $response->withRedirect('/login');
	}
});

$app->get('/student/create-new', function ($request, $response, $args) {
	session_start();
	//var_dump($_SESSION['admin_id']);
	if (isset($_SESSION['admin_id'])) {
		$admin = Administrator::getOne($_SESSION['admin_id']);
		$courses = Course::getAll();
		$students = Student::getAll();
		$checkbox_info = Course::GetNamesAndIds();
		return $this->view->render($response, 'create_student.html', [
			'admin' => $admin,
			'courses' => $courses,
			'students' => $students,
			'checkbox_info' => $checkbox_info
		]);
	} else {
		return $response->withRedirect('/login');
	}
});

$app->get('/course/create-new', function ($request, $response, $args) {
	session_start();
	if (isset($_SESSION['admin_id'])) {
		$admin = Administrator::getOne($_SESSION['admin_id']);
		$courses = Course::getAll();
		$students = Student::getAll();
		return $this->view->render($response, 'create_course.html', [
			'admin' => $admin,
			'courses' => $courses,
			'students' => $students,
		]);
	} else {
		return $response->withRedirect('/login');
	}
});

$app->get('/administrator/create-new', function ($request, $response, $args) {
	session_start();
	if (isset($_SESSION['admin_id'])) {
		if ($_SESSION['admin_role_id'] === 3) { //sales has no access
			return $response->withRedirect('/home');
		}
		$admin = Administrator::getOne($_SESSION['admin_id']);
		$administrators = Administrator::getAll();
		return $this->view->render($response, 'create_administrator.html', [
			'administrators' => $administrators,
			'admin' => $admin
		]);
	} else {
		return $response->withRedirect('/login');
	}
});  

$app->post('/administrator/create-new/created', function ($request, $response, $args) {
	$body = $request->getParsedBody();
	$errors_detected = Administrator::validateBasicData($body['name'], $body['phone'], $body['email']);
	if (!Administrator::validatePassword($body['password'])) {
		$errors_detected['password'] = "Password must contain at least one number and one letter";
	} 
	$uploaddir = 'c:/xampp/htdocs/school/views/images/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	if ((move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) && (empty($errors_detected) == true)) {
		var_dump($errors_detected);
		var_dump("success");
		$new_administrator = new Administrator($body['name'], $body['role_id'], $body['phone'], $body['email'], $body['password'], 'images/' . basename($_FILES['userfile']['name']));
		$new_administrator_id = $new_administrator->save();
		return $response->withRedirect('/administrator' . '/' . $new_administrator_id);	
	} else {
		if ($_FILES['userfile']['error'] !== 0) { //0 means no errors at all
			$errors_detected['image'] = "Image error is " . $_FILES['userfile']['error'];	
		}
    	return $this->view->render($response, 'errors.html', [
			'errors' => $errors_detected
		]);
	} 	
});

$app->post('/course/create-new/created', function ($request, $response, $args) {
	$body = $request->getParsedBody();
	$uploaddir = 'c:/xampp/htdocs/school/views/images/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	//echo 'Here is some more debugging info:';
	//print_r($_FILES);
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		$new_course = new Course($body['course_name'], $body['course_description'], 'images/' . basename($_FILES['userfile']['name']));
		$new_course_id = $new_course->save();
	    return $response->withRedirect('/course' . '/' . $new_course_id);
	} else {
	    echo "Possible file upload attack!\n";
	    return;
	}	
});

$app->post('/student/create-new/created', function ($request, $response, $args) {
	$body = $request->getParsedBody();
	$uploaddir = 'c:/xampp/htdocs/school/views/images/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	$errors_detected = Student::validateBasicData($body['name'], $body['phone'], $body['email']);
	//echo 'Here is some more debugging info:';
	//print_r($_FILES);
	if ((move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) && (empty($errors_detected) == true)) {
	    $new_student = new Student($body['name'], $body['phone'], $body['email'], 'images/' . basename($_FILES['userfile']['name']));

		$new_student_id = $new_student->save();
		for ($i=0; $i < count($body['courses_chosen_id']); $i++) { 
			Student::enroll($body['courses_chosen_id'][$i], $new_student_id);
		}
	    return $response->withRedirect('/student' . '/' . $new_student_id);
	} else {
		if ($_FILES['userfile']['error'] !== 0) { //0 means no errors at all
			$errors_detected['image'] = "Image error is " . $_FILES['userfile']['error'];	
		}
    	return $this->view->render($response, 'errors.html', [
			'errors' => $errors_detected
		]);
	}	
});  

$app->post('/course/edited/{course_id:\d+}', function ($request, $response, $args) {
	$course_id = $args['course_id'];
	$specific_course = Course::getOne($course_id);
	$body = $request->getParsedBody();
	$uploaddir = 'c:/xampp/htdocs/school/views/images/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		$image = 'images/' . basename($_FILES['userfile']['name']);
	} else {
		$image = $specific_course['image_link'];
	}
	Course::update($body['course_name'], $body['course_description'], $image, $course_id);
	return $response->withRedirect('/course' . '/' . $course_id);	
	//echo 'Here is some more debugging info:';
	//print_r($_FILES);
}); 	

$app->post('/student/edited/{student_id:\d+}', function ($request, $response, $args) {
	$student_id = $args['student_id'];
	$specific_student = student::getOne($student_id);
	$body = $request->getParsedBody();
	$errors_detected = Student::validateBasicData($body['name'], $body['phone'], $body['email']);
	$uploaddir = 'c:/xampp/htdocs/school/views/images/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
	    $image = 'images/' . basename($_FILES['userfile']['name']);
	} else {
		$image = $specific_student['image_link'];
	}	
	if (empty($errors_detected) == true) {
		Student::update($body['name'], $body['phone'], $body['email'], $image, $student_id);
		$previously_signed_to = Student::findCourses($student_id);
		$previously_signed_to_id = [];
		for ($i=0; $i < count($previously_signed_to); $i++) { 
			$previously_signed_to_id [] = $previously_signed_to[$i]['id'];
		}
		if (!empty($body['new_courses_chosen'])) {
			$new_courses_signed_to_id = $body['new_courses_chosen'];
		}
		if ((!empty($new_courses_signed_to_id)) && (!empty($previously_signed_to_id))){
			for ($i=0; $i < count($previously_signed_to_id); $i++) { 
				if (!in_array($previously_signed_to_id[$i], $new_courses_signed_to_id)) {
				   	Student::deleteEnrollment($previously_signed_to_id[$i], $student_id);
				}
			}
			for ($i=0; $i < count($new_courses_signed_to_id); $i++) { 
				if (!in_array($new_courses_signed_to_id[$i], $previously_signed_to_id)) {
			   		Student::enroll($new_courses_signed_to_id[$i], $student_id);
				}
			}
		}
		if ((!empty($new_courses_signed_to_id)) && (empty($previously_signed_to_id))) {
			for ($i=0; $i < count($new_courses_signed_to_id); $i++) {
				Student::enroll($new_courses_signed_to_id[$i], $student_id);
			}
		}
		if ((empty($new_courses_signed_to_id)) && (!empty($previously_signed_to_id))) {
			for ($i=0; $i < count($previously_signed_to_id); $i++) {
				Student::deleteEnrollment($previously_signed_to_id[$i], $student_id);
			}
		}
		return $response->withRedirect('/student' . '/' . $student_id);
	} else {
		return $this->view->render($response, 'errors.html', [
			'errors' => $errors_detected
		]);
	}
}); 

$app->post('/administrator/edited/{administrator_id:\d+}', function ($request, $response, $args) {
	$administrator_id = $args['administrator_id'];
	$specific_administrator = Administrator::getOne($administrator_id);
	$body = $request->getParsedBody();
	$errors_detected = Administrator::validateBasicData($body['name'], $body['phone'], $body['email']);
	$uploaddir = 'c:/xampp/htdocs/school/views/images/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
	    $image = 'images/' . basename($_FILES['userfile']['name']);
	} else {
		$image = $specific_administrator['image_link'];
	}	
	if ((empty($errors_detected) == true) && ($body['role_id'] !== 1)) { //a new owner canoot be created
		Administrator::update($body['name'], $body['email'], $body['phone'], $body['role_id'], $image, $administrator_id);
		return $response->withRedirect('/administrator' . '/' . $administrator_id);
	} else {
		return $this->view->render($response, 'errors.html', [
			'errors' => $errors_detected
		]);
	}
});

$app->post('/course/delete/{course_id:\d+}', function ($request, $response, $args) {
	$course_id = $args['course_id'];
	Course::delete($course_id);
	return $response->withRedirect('/home');
});

$app->post('/student/delete/{student_id:\d+}', function ($request, $response, $args) {
	$student_id = $args['student_id'];
	Student::delete($student_id);
	return $response->withRedirect('/home');
}); 

$app->post('/administrator/delete/{administrator_id:\d+}', function ($request, $response, $args) {
	$administrator_id = $args['administrator_id'];
	Administrator::delete($administrator_id);
	return $response->withRedirect('/administrator-home');
});

