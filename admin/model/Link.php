<?php

class Link extends Elem {

   var $onServer = NULL;
   var $label = NULL;
   var $target = NULL;
   var $uploadId = NULL;
   var $sectionId = NULL;

   function __construct() {
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
 }
?>