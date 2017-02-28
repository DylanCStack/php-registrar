<?php
    class Student
    {
        private $first_name;
        private $last_name;
        private $id;

        function __construct($first, $last, $id = null)
        {
            $this->first_name = $first;
            $this->last_name = $last;
            $this->id = $id;
        }

        function getFirstName()
        {
            return $this->first_name;
        }

        function setFirstName($new_first_name)
        {
            $this->first_name = (string) $new_first_name;
        }
        function getLastName()
        {
            return $this->last_name;
        }

        function setLastName($new_last_name)
        {
            $this->last_name = (string) $new_last_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students(first_name, last_name) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}')");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_first_name, $new_last_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET first_name = '{$new_first_name}', last_name = '{$new_last_name}' WHERE id = {$this->id}");

            $this->setFirstName($new_first_name);
            $this->setLastName($new_last_name);
        }

        function addCourse($new_course)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_students(course_id, student_id) VALUES ({$new_course->getId()}, {$this->getId()})");
        }

        function getCourses()
        {
            $returned_courses = $GLOBALS['DB']->query(
            "SELECT courses.* FROM students JOIN courses_students ON (courses_students.student_id = students.id) JOIN courses ON (courses.id = courses_students.course_id) WHERE students.id = {$this->getId()};");

            $courses = [];
            foreach($returned_courses as $course)
            {
                $id = $course['id'];
                $name = $course['name'];
                $description = $course['description'];
                $prof_name = $course['prof_name'];
                $units = $course['units'];
                $new_course = new Course($name, $description, $prof_name, $units, $id);

                array_push($courses, $new_course);
            }
            return $courses;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
        }

        static function find($id)
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students WHERE id={$id};");

            if($returned_students){
                foreach($returned_students as $student)
                {
                    $first = $student["first_name"];
                    $last = $student['last_name'];
                    $id = $student['id'];
                    $new_student = new Student($first, $last, $id);
                    return $new_student;
                }
            }


        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $output_array = [];
            if($returned_students){
                foreach($returned_students as $student)
                {
                    $first = $student["first_name"];
                    $last = $student['last_name'];
                    $id = $student['id'];
                    $new_student = new Student($first, $last, $id);
                    array_push($output_array, $new_student);
                }
            }
            return $output_array;

        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }


    }
?>
