<?php

class Textarea extends Elem {

   var $sectionId;
   var $isTwoCol;
   var $contentCol1;
   var $contentCol2;

   function __construct() {
      parent::__construct();
      $this->sectionId = -1;
      $this->isTwoCol = false;
      $this->contentCol1 = "";
      $this->contentCol2 = "";
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

   function toBDD() {
      $q = "DELETE FROM adm_textarea WHERE id='" . $this->id . "'; ";
      $q .= "INSERT INTO adm_textarea(id, sectionId, isTwoCol, contentCol1, contentCol2, rank)" 
         . "VALUES('" . $this->id . "', '" . $this->sectionId . "', '" . $this->isTwoCol . "', '" . $this->contentCol1 . "', '" . $this->contentCol2 . "', '" . $this->rank . "'); ";
      return $q;
   }
 }
?>