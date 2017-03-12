<?php

class Link extends Elem {

   var $onServer = NULL;
   var $label = NULL;
   var $target = NULL;
   var $uploadId = NULL;
   var $sectionId = NULL;

   function __construct($tuple) {
      parent::__construct($tuple);
      $this->onServer = $tuple['onServer'];
      $this->label = $tuple['label'];
      $this->target = $tuple['target'];
      $this->uploadId = $tuple['uploadId'];
      $this->sectionId = $tuple['sectionId'];
   }

   function toFrontEnd() {
   }
 }
?>