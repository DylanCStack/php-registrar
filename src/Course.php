<?php
    class Student
    {
        private $name;
        private $description;
        private $prof_name;
        private $units;
        private $id;

        function __construct($name, $desctiption, $prof_name, $units,  $id = null)
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

        }

        static function getAll()
        {

        }

        static function deleteAll()
        {

        }
    }
?>
