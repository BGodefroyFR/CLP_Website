<?php

class Section extends Elem {

   var $title = NULL;
   var $textColor = NULL;
   var $backgroundColor = NULL;
   var $backgroundPattern = NULL;

   function __construct($tuple) {
      parent::__construct($tuple);
      $this->title = $tuple['title'];
      $this->textColor = $tuple['textColor'];
      $this->backgroundColor = $tuple['backgroundColor'];
      $this->backgroundPattern = $tuple['backgroundPattern'];
   }

   function toFrontEnd() {
   }
 }
?>