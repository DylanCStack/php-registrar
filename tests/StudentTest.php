<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once 'src/Student.php';
    $server = 'mysql:host=localhost:8889;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    Class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
        }

        function test_save()
        {
            Student::deleteAll();
            $first = "Clayton";
            $last = "Smith";
            $id = null;
            $test_student= new Student($first, $last, $id);

            //Act
            $test_student->save();
            $result = Student::getAll();
            // Assert
            $this->assertEquals([$test_student], $result);

        }

        function test_deleteAll()
        {
            // Arrange
            $first = "Clayton";
            $last = "Smith";
            $id = null;
            $test_student = new Student($first, $last, $id);
            // Act
            $test_student->save();
            Student::deleteAll();
            $result = Student::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            // Arrange
            $first = "Clayton";
            $last = "Smith";
            $id = null;
            $test_student = new Student($first, $last, $id);
            $test_student->save();

            // Act
            $result = Student::find($test_student->getId());

            // Assert
            $this->assertEquals($test_student, $result);
        }

        function test_update()
        {
            // Arrange
            $first = "Clayton";
            $last = "Smith";
            $id = null;
            $test_student = new Student($first, $last, $id);
            $test_student->save();
            // Act
            $new_first_name = "Juan";
            $new_last_name = "Lopez";

            $test_student->update($new_first_name, $new_last_name);


            $result = Student::find( $test_student->getId())->getFirstName();
            // Assert
            $this->assertEquals($test_student->getFirstName(), $result);
        }

        function test_delete()
        {
            // Arrange
            $first = "Sean";
            $last = "Peterson";
            $id = null;
            $new_student = new Student($first, $last, $id);
            $new_student->save();

            $first2 = "Clayton";
            $last2 = "Lopez";
            $id2 = null;
            $new_student2 = new Student($first2, $last2, $id2);
            $new_student2->save();
            // Act
            $new_student->delete();
            $result = Student::getAll();
            // Assert
            $this->assertEquals([$new_student2],$result);
        }

    }
?>
