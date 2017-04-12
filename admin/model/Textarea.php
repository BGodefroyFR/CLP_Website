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

   function loadFromDB($tuple) {
      parent::loadFromDB($tuple);
      $this->sectionId = $tuple['sectionId'];
      $this->isTwoCol = $tuple['isTwoCol'];
      $this->contentCol1 = stripslashes($tuple['contentCol1']);
      $this->contentCol2 = stripslashes($tuple['contentCol2']);
   }

   function createFromForm($sectionId, $isTwoCol, $contentCol1, $contentCol2, $rank) {
      $this->sectionId = $sectionId;
      $this->isTwoCol = $isTwoCol;
      $this->contentCol1 = $contentCol1;
      $this->contentCol2 = $contentCol2;
      $this->rank = $rank;
   }

   function toSectionForm() {
      $content = file_get_contents('../view/asset/curTextArea.html');
      $content = str_replace('<CONTENTLEFT>', stripslashes($this->contentCol1), $content);

      if ($this->isTwoCol) {
         $content = str_replace('<IS2COL>', 'checked', $content);
         $content = str_replace('<DISPLAYRIGHTCOL>', 'display: inline-block;', $content);
         $content = str_replace('<CONTENTRIGHT>', stripslashes($this->contentCol2), $content);
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

   function toSQL() {
      $q = "INSERT INTO adm_textarea(id, sectionId, isTwoCol, contentCol1, contentCol2, rank)" 
         . "VALUES('" . $this->id . "', '" . $this->sectionId . "', '" . $this->isTwoCol . "', '" . addslashes($this->contentCol1) . "', '" . addslashes($this->contentCol2) . "', '" . $this->rank . "'); ";
      return $q;
   }

   function toWebsite() {
      $content = "";
      $col1 = str_replace('../../images/textImages/', 'images/textImages/', $this->contentCol1);
      $col2 = str_replace('../../images/textImages/', 'images/textImages/', $this->contentCol2);  

      if ($this->isTwoCol) {
         $content = file_get_contents('../../assets/html_chuncks/textarea_2col.html');
         $content = str_replace('<COL1>', stripslashes($col1), $content);
         $content = str_replace('<COL2>', stripslashes($col2), $content);
      } else {
         $content = file_get_contents('../../assets/html_chuncks/textarea.html');
         $content = str_replace('<CONTENT>', stripslashes($col1), $content);
      }
      return $content;
   }

   function delete() {
      $q = "DELETE FROM adm_textarea WHERE id = '" . $this->id . "'; ";
      executeQuery($q);
   }
 }
?>