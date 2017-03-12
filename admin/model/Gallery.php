<?php

class Gallery extends Elem {

   var $sectionId = NULL;

   function __construct($tuple) {
      parent::__construct($tuple);
      $this->sectionId = $tuple['sectionId'];
   }

   function toFrontEnd() {
   }
 }
?>