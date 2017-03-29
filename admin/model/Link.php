<?php

class Link extends Elem {

   var $onServer;
   var $label;
   var $target;
   var $uploadId;
   var $sectionId;

   function __construct() {
      parent::__construct();
      $this->onServer = false;
      $this->label = "";
      $this->target = "";
      $this->uploadId = -1;
      $this->sectionId = -1;
   }

   function createFromBdd($tuple) {
      parent::createFromBdd($tuple);
      $this->onServer = $tuple['onServer'];
      $this->label = $tuple['label'];
      $this->target = $tuple['target'];
      $this->uploadId = $tuple['uploadId'];
      $this->sectionId = $tuple['sectionId'];
   }

   function createFromForm($onServer, $label, $target, $uploadId, $sectionId, $rank) {
      $this->onServer = $onServer;
      $this->label = $label;
      $this->target = $target;
      $this->uploadId = $uploadId;
      $this->sectionId = $sectionId;
      $this->rank = $rank;
   }

   function toFrontEnd() {
   }

   function toBDD() {
      $q = "DELETE FROM adm_link WHERE id='" . $this->id . "'; ";
      $q .= "INSERT INTO adm_link(id, onServer, label, target, uploadId, sectionId, rank)" 
         . "VALUES('" . $this->id . "', '" . $this->onServer . "', '" . $this->label . "', '" . $this->target . "', '" . $this->uploadId . "', '" . $this->sectionId . "', '" . $this->rank . "'); ";
      return $q;
   }
 }
?>