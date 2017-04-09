<?php

class Link extends Elem {

   var $onServer;
   var $label;
   var $target;
   var $upload;
   var $sectionId;

   function __construct() {
      parent::__construct();
      $this->onServer = false;
      $this->label = "";
      $this->target = "";
      $this->upload = null;
      $this->sectionId = -1;
   }

   function loadFromDB($tuple) {
      parent::loadFromDB($tuple);
      $this->onServer = $tuple['onServer'];
      $this->label = $tuple['label'];
      $this->target = $tuple['target'];
      $this->upload = new Upload();
      $this->upload->loadFromDB($tuple['uploadId']);
      $this->sectionId = $tuple['sectionId'];
   }

   function createFromForm($onServer, $label, $target, $uploadId, $sectionId, $rank) {
      $this->onServer = $onServer;
      $this->label = $label;
      $this->target = $target;
      $this->upload = new Upload();
      $this->upload->loadFromDB($uploadId);
      $this->sectionId = $sectionId;
      $this->rank = $rank;
   }

   function toSectionForm() {
      $content = file_get_contents('../view/asset/curLink.html');
      $content = str_replace('<LINK_LABEL>', $this->label, $content);

      $url = "";
      if (!$this->onServer) {
         $url = $this->target;
      } else {
         $url = $this->upload->initialName;
      }
      $content = str_replace('<LINK_TARGET>', $url, $content);
      $content = str_replace('<UPLOADID>', $this->upload->id, $content);
      $content = str_replace('<ISONSERVER>', $this->onServer, $content);
      $content = str_replace('<RANDOMID>', rand(1,1e9), $content);
      
      return $content;
   }

   function toSQL() {
      $q = "";
      $uploadId = -1;
      if ($this->upload != null) {
         $q .= $this->upload->toSQL();
         $uploadId = $this->upload->id;
      }
      $q .= "INSERT INTO adm_link(id, onServer, label, target, uploadId, sectionId, rank)" 
         . "VALUES('" . $this->id . "', '" . $this->onServer . "', '" . $this->label . "', '" . $this->target . "', '" . $uploadId . "', '" . $this->sectionId . "', '" . $this->rank . "'); ";
      return $q;
   }

   function toWebsite() {
      $content = file_get_contents('../../assets/html_chuncks/link.html');
      $ref = $this->target;
      if ($this->onServer && $this->upload != null) {
         $ref = $this->upload->path;
      }
      $content = str_replace('<REF>', $ref, $content);
      $content = str_replace('<LABEL>', $this->label, $content);
      return $content;
   }

   function delete($removeUploads) {
      if ($removeUploads) {
         $this->upload->delete();
      }
      $q = "DELETE FROM adm_link WHERE id = '" . $this->id . "'; ";
      executeQuery($q);
   }
 }
?>