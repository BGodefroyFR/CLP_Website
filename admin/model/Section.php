<?php

class Section extends Elem {

   var $title;
   var $textColor;
   var $backgroundColor;
   var $backgroundPattern;

   function __construct() {
      parent::__construct();
      $this->title = "";
      $this->textColor = "";
      $this->backgroundColor = "";
      $this->backgroundPattern = "";
   }

   function createFromBdd($tuple) {
      parent::createFromBdd($tuple);
      $this->title = $tuple['title'];
      $this->textColor = $tuple['textColor'];
      $this->backgroundColor = $tuple['backgroundColor'];
      $this->backgroundPattern = $tuple['backgroundPattern'];
   }

   function createFromForm($title, $textColor, $backgroundColor, $backgroundPattern, $rank, $id) {
      $this->title = $title;
      $this->textColor = $textColor;
      $this->backgroundColor = $backgroundColor;
      $this->backgroundPattern = $backgroundPattern;
      $this->rank = $rank;
      $this->id = $id;
   }

   function toFrontEnd() {
   }

   function toBDD() {
      $q = "INSERT INTO adm_section(id, title, textColor, backgroundColor, backgroundPattern, rank)" 
         . "VALUES('" . $this->id . "', '" . $this->title . "', '" . $this->textColor . "', '" . $this->backgroundColor . "', '" . $this->backgroundPattern . "', '" . $this->rank . "'); ";
      return $q;
   }
 }
?>