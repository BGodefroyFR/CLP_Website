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

   function toFrontEnd($uploads) {
      $content = file_get_contents('../view/asset/curLink.html');
      $content = str_replace('<LINK_LABEL>', $this->label, $content);

      $url = "";
      if ($this->uploadId == -1) {
         $url = $this->target;
      } else {
         foreach($uploads as $u) {
            if ($u->id == $this->uploadId) {
               $url = $u->initialName;
               break;
            }
         }
      }
      $content = str_replace('<LINK_TARGET>', $url, $content);
      $content = str_replace('<UPLOADID>', $this->uploadId, $content);
      $content = str_replace('<ISONSERVER>', $this->onServer, $content);
      $content = str_replace('<RANDOMID>', rand(1,1e9), $content);
      
      return $content;
   }

   function toBDD() {
      $q = "INSERT INTO adm_link(id, onServer, label, target, uploadId, sectionId, rank)" 
         . "VALUES('" . $this->id . "', '" . $this->onServer . "', '" . $this->label . "', '" . $this->target . "', '" . $this->uploadId . "', '" . $this->sectionId . "', '" . $this->rank . "'); ";
      return $q;
   }
 }
?>