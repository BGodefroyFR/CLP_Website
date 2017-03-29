<?php

class Section extends Elem {

   var $title = NULL;
   var $textColor = NULL;
   var $backgroundColor = NULL;
   var $backgroundPattern = NULL;

   function __construct() {
   }

   function createFromBdd($tuple) {
      parent::createFromBdd($tuple);
      $this->title = $tuple['title'];
      $this->textColor = $tuple['textColor'];
      $this->backgroundColor = $tuple['backgroundColor'];
      $this->backgroundPattern = $tuple['backgroundPattern'];
   }

   function createFromForm($title, $textColor, $backgroundColor, $backgroundPattern, $rank) {
      $this->title = $title;
      $this->textColor = $textColor;
      $this->backgroundColor = $backgroundColor;
      $this->backgroundPattern = $backgroundPattern;
      $this->rank = $rank;
   }

   function toFrontEnd() {
   }
 }
?>