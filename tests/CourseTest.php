<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once 'src/Course.php';
    require_once 'src/Student.php';
    $server = 'mysql:host=localhost:8889;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    Class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function test_save()
        {
            $name = "Jamaican Basket Weaving 101";
            $description = "Everything you think and more";
            $prof_name = "Dr. Doctorof";
            $units = 3;
            $id = null;
            $test_course= new Course($name, $description, $prof_name, $units, $id);

            //Act
            $test_course->save();
            $result = Course::getAll();
            // Assert
            $this->assertEquals([$test_course], $result);

        }

        function test_deleteAll()
        {
            // Arrange
            $name = "Jamaican Basket Weaving 101";
            $description = "Everything you think and more";
            $prof_name = "Dr. Doctorof";
            $units = 3;
            $id = null;
            $test_course= new Course($name, $description, $prof_name, $units, $id);
            // Act
            $test_course->save();
            Course::deleteAll();
            $result = Course::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            // Arrange
            $name = "Jamaican Basket Weaving 101";
            $description = "Everything you think and more";
            $prof_name = "Dr. Doctorof";
            $units = 3;
            $id = null;
            $test_course= new Course($name, $description, $prof_name, $units, $id);
            $test_course->save();

            // Act
            $result = Course::find($test_course->getId());

            // Assert
            $this->assertEquals($test_course, $result);
        }

        function test_update()
        {
            // Arrange
            $name = "Jamaican Basket Weaving 101";
            $description = "Everything you think and more";
            $prof_name = "Dr. Doctorof";
            $units = 3;
            $id = null;
            $test_course= new Course($name, $description, $prof_name, $units, $id);
            $test_course->save();
            // Act
            $new_name = "Php for Single Grandmothers with Cats 310";
            $new_description = "Something else now";
            $new_prof_name = "Mr. Dr. Professor";
            $new_units = 2;

            $test_course->update($new_name, $new_description, $new_prof_name, $new_units);


            $result = Course::find( $test_course->getId())->getName();
            // Assert
            $this->assertEquals($test_course->getName(), $result);
        }

        function test_delete()
        {
            // Arrange
            $name = "Jamaican Basket Weaving 101";
            $description = "Everything you think and more";
            $prof_name = "Dr. Doctorof";
            $units = 3;
            $id = null;
            $test_course= new Course($name, $description, $prof_name, $units, $id);
            $test_course->save();

            $name2 = "Skydiving for the blind 150";
            $description2 = "Everything you think and more";
            $prof_name2 = "Dr. Doctorof";
            $units2 = 3;
            $id2 = null;
            $test_course2= new Course($name2, $description2, $prof_name2, $units2, $id2);
            $test_course2->save();
            // Act
            $test_course->delete();
            $result = Course::getAll();
            // Assert
            $this->assertEquals([$test_course2],$result);
        }

        function test_addStudent()
        {
            $name = "Jamaican Basket Weaving 101";
            $description = "Everything you think and more";
            $prof_name = "Dr. Doctorof";
            $units = 3;
            $id = null;
            $test_course= new Course($name, $description, $prof_name, $units, $id);
            $test_course->save();

            $first = "Sean";
            $last = "Peterson";
            $id2 = null;
            $test_student = new Student($first, $last, $id2);
            $test_student->save();
            //Act
            $test_course->addStudent($test_student);
            $result = $test_course->getStudents();
            //Assert
            $this->assertEquals($result, [$test_student]);
        }

    }
?>
