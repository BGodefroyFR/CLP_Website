<?php

class Textarea extends Elem {

   var $sectionId = NULL;
   var $isTwoCol = NULL;
   var $contentCol1 = NULL;
   var $contentCol2 = NULL;

   function __construct() {
   }

   function createFromBdd($tuple) {
      parent::createFromBdd($tuple);
      $this->sectionId = $tuple['sectionId'];
      $this->isTwoCol = $tuple['isTwoCol'];
      $this->contentCol1 = $tuple['contentCol1'];
      $this->contentCol2 = $tuple['contentCol2'];
   }

   function createFromForm($sectionId, $isTwoCol, $contentCol1, $contentCol2, $rank) {
      $this->sectionId = $sectionId;
      $this->isTwoCol = $isTwoCol;
      $this->contentCol1 = $contentCol1;
      $this->contentCol2 = $contentCol2;
      $this->rank = $rank;
   }

   function toFrontEnd() {
   }
 }
?>