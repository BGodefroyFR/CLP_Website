<?php
   abstract class Elem {
      var $id;
      var $timestamp;
      var $rank;

      function __construct() {
         $this->id = rand(1,1e9);
         $this->rank = -1;
      }

	  function loadFromDB($tuple) {
	      $this->id = $tuple['id'];
	      $this->timestamp = $tuple['timestamp'];
         if (isset($tuple['rank']))
	        $this->rank = $tuple['rank'];
	  }
   }
?>