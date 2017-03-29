<?php
   abstract class Elem {
      var $id;
      var $timestamp;
      var $rank;

      function __construct() {
         $id = rand(1,1e9);
         $rank = -1;
      }

	  function createFromBdd($tuple) {
	      $this->id = $tuple['id'];
	      $this->timestamp = $tuple['timestamp'];
	      $this->rank = $tuple['rank'];
	  }
   }
?>