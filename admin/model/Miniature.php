<?php

class Miniature extends Elem {

   var $sectionId = NULL;
   var $imageId = NULL;

   function __construct($tuple) {
      parent::__construct($tuple);
      $this->sectionId = $tuple['sectionId'];
      $this->imageId = $tuple['imageId'];
   }

   function toFrontEnd() {
   }
 }
?>