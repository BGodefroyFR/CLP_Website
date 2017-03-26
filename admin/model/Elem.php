<?php
   abstract class Elem {
      var $id;
      var $timestamp;
      var $rank;

      function __construct() {
      }

	  function createFromBdd($tuple) {
	      $this->id = $tuple['id'];
	      $this->timestamp = $tuple['timestamp'];
	      $this->rank = $tuple['rank'];
	  }

	  function createFromForm($id, $timestamp, $rank) {
	      $this->id = $id;
	      $this->timestamp = $timestamp;
	      $this->rank = $rank;
	   }
   }
?>