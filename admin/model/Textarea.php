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
      $content = file_get_contents('../view/asset/curTextArea.html');
      $content = str_replace('<CONTENTLEFT>', $this->contentCol1, $content);

      if ($this->isTwoCol) {
         $content = str_replace('<IS2COL>', 'checked', $content);
         $content = str_replace('<DISPLAYRIGHTCOL>', 'display: inline-block;', $content);
         $content = str_replace('<CONTENTRIGHT>', $this->contentCol2, $content);
         $content = str_replace('<LEFTCOLWIDTH>', '45', $content);
         $content = str_replace('<LEFTCOLLABEL>', 'Colonne gauche', $content);
      } else {
         $content = str_replace('<IS2COL>', '', $content);
         $content = str_replace('<DISPLAYRIGHTCOL>', 'display:none;', $content);
         $content = str_replace('<CONTENTRIGHT>', '', $content);
         $content = str_replace('<LEFTCOLWIDTH>', '90', $content);
         $content = str_replace('<LEFTCOLLABEL>', '', $content);
      }
      return $content;
   }

   function toBDD() {
      $q = "DELETE FROM adm_textarea WHERE id='" . $this->id . "'; ";
      $q .= "INSERT INTO adm_textarea(id, sectionId, isTwoCol, contentCol1, contentCol2, rank)" 
         . "VALUES('" . $this->id . "', '" . $this->sectionId . "', '" . $this->isTwoCol . "', '" . $this->contentCol1 . "', '" . $this->contentCol2 . "', '" . $this->rank . "'); ";
      return $q;
   }
 }
?>