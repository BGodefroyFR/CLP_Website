<?php

class Upload extends Elem {

   var $path = NULL;

   function __construct($tuple) {
      parent::__construct($tuple);
      $this->path = $tuple['path'];
   }

   function toFrontEnd() {
   }
 }
?>