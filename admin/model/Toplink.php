<?php

class Toplink extends Elem {

   var $sectionId = NULL;
   var $label = NULL;

   function __construct($tuple) {
      parent::__construct($tuple);
      $this->sectionId = $tuple['sectionId'];
      $this->label = $tuple['label'];
   }

   function toFrontEnd() {
   }
 }
?>