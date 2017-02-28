<?php
    class Course
    {
        private $name;
        private $description;
        private $prof_name;
        private $units;
        private $id;

        function __construct($name, $description, $prof_name, $units,  $id = null)
        {
            $this->name = $name;
            $this->description = $description;
            $this->prof_name = $prof_name;
            $this->units = $units;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getDescription()
        {
            return $this->description;
        }

        function setDescription($new_description)
        {
            $this->description = $new_description;
        }

        function getProfName()
        {
            return $this->prof_name;
        }

        function setProfName($new_prof_name)
        {
            $this->prof_name = $new_prof_name;
        }

        function getUnits()
        {
            return $this->units;
        }

        function setUnits($new_units)
        {
            $this->units = $new_units;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses(name, description, prof_name, units) VALUES ('{$this->getName()}', '{$this->getDescription()}', '{$this->getProfName()}', {$this->getUnits()})");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name, $new_description, $new_prof_name, $new_units)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET name = '{$new_name}', description = '{$new_description}', prof_name = '{$new_prof_name}', units = {$new_units} WHERE id = {$this->id}");

            $this->setName($new_name);
            $this->setDescription($new_description);
            $this->setProfName($new_prof_name);
            $this->setUnits($new_units);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
        }

        static function find($id)
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id={$id};");

            if($returned_courses){
                foreach($returned_courses as $course)
                {
                    $name = $course["name"];
                    $description = $course['description'];
                    $prof_name = $course['prof_name'];
                    $units = $course['units'];
                    $id = $course['id'];
                    $new_course = new Course($name, $description, $prof_name, $units, $id);
                    return $new_course;
                }
            }


        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $output_array = [];
            if($returned_courses){
                foreach($returned_courses as $course)
                {
                    $name = $course["name"];
                    $description = $course['description'];
                    $prof_name = $course['prof_name'];
                    $units = $course['units'];
                    $id = $course['id'];
                    $new_course = new Course($name, $description, $prof_name, $units, $id);
                    array_push($output_array, $new_course);
                }
            }
            return $output_array;

        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }
    }
?>
