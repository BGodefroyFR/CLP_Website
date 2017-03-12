<?php
   abstract class Elem {

      var $id;
      var $timestamp;
      var $rank;

      abstract function toFrontEnd();

      function __construct($tuple) {
         $this->id = $tuple['id'];
         $this->timestamp = $tuple['timestamp'];
         $this->rank = $tuple['rank'];
      }
   }
?>