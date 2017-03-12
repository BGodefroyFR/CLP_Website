<?php

class Textarea extends Elem {

   var $sectionId = NULL;
   var $isTwoCol = NULL;
   var $contentCol1 = NULL;
   var $contentCol2 = NULL;

   function __construct($tuple) {
      parent::__construct($tuple);
      $this->sectionId = $tuple['sectionId'];
      $this->isTwoCol = $tuple['isTwoCol'];
      $this->contentCol1 = $tuple['contentCol1'];
      $this->contentCol2 = $tuple['contentCol2'];
   }

   function toFrontEnd() {
   }
 }
?>