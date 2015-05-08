<?php

require_once('Model/Dao/CourseRepository.php');
require_once('Model/Dao/UserRepository.php');


$courseRepository = new CourseRepository();
$userRepository = new UserRepository();

$keyword = '%'.$_POST['keyword'].'%';

$listCourses = $courseRepository->searchAutoComplete($keyword);
$listUsers = $userRepository->searchAutoCompleteUserNames($keyword);


foreach ($listCourses as $lc) {

	$course_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $lc['CourseName']);
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $lc['CourseName']).'\')">'.$course_name.'</li>';
}

foreach ($listUsers as $lu) {

	$user_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $lu['Username']);
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $lu['Username']).'\')">'.$user_name.'</li>';
}