<?php

class GalleryImage extends Elem {

   var $galleryId = NULL;
   var $imageId = NULL;

   function __construct($tuple) {
      parent::__construct($tuple);
      $this->galleryId = $tuple['galleryId'];
      $this->imageId = $tuple['imageId'];
   }

   function toFrontEnd() {
   }
 }
?>