<?php

require_once('Model/Dao/CourseRepository.php');

$courseRepository = new CourseRepository();

$keyword = '%'.$_POST['keyword'].'%';

$list = $courseRepository->searchAutoComplete($keyword);

foreach ($list as $rs) {

	$course_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['CourseName']);
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['CourseName']).'\')">'.$course_name.'</li>';
}