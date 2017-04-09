<?php
include 'Miniature.php';
include 'Toplink.php';
include 'Link.php';
include 'Gallery.php';
include 'Textarea.php';

class Section extends Elem {

   var $title;
   var $textColor;
   var $backgroundColor;
   var $backgroundPattern;

   var $rank;

   var $miniature = null;
   var $toplink = null;

   var $links = array();
   var $galleries = array();
   var $textareas = array();

   function __construct() {
      parent::__construct();
      $this->title = "Nouvelle section";
      $this->textColor = "#5c5c5c";
      $this->backgroundColor = "#e0e0e0";
      $this->backgroundPattern = "Uni";
   }

   function loadFromDB($tuple) {
      parent::loadFromDB($tuple);
      $this->title = $tuple['title'];
      $this->textColor = $tuple['textColor'];
      $this->backgroundColor = $tuple['backgroundColor'];
      $this->backgroundPattern = $tuple['backgroundPattern'];
      $this->rank = $tuple['rank'];

      // miniature
      $r = executeQuery("SELECT * FROM adm_miniature WHERE sectionId = '" . $this->id . "'");
      if($d = $r->fetch()) {
         $this->miniature = new Miniature();
         $this->miniature->loadFromDB($d);
      }
      // toplink
      $r = executeQuery("SELECT * FROM adm_toplink WHERE sectionId = '" . $this->id . "'");
      if($d = $r->fetch()) {
         $this->toplink = new Toplink();
         $this->toplink->loadFromDB($d);
      }
      // links
      $r = executeQuery("SELECT * FROM adm_link WHERE sectionId = '" . $this->id . "'");
      while($d = $r->fetch()) {
         $e = new Link();
         $e->loadFromDB($d);
         array_push($this->links, $e);
      }
      // galleries
      $r = executeQuery("SELECT * FROM adm_gallery WHERE sectionId = '" . $this->id . "'");
      while($d = $r->fetch()) {
         $e = new Gallery();
         $e->loadFromDB($d);
         array_push($this->galleries, $e);
      }
      // textareas
      $r = executeQuery("SELECT * FROM adm_textarea WHERE sectionId = '" . $this->id . "'");
      while($d = $r->fetch()) {
         $e = new Textarea();
         $e->loadFromDB($d);
         array_push($this->textareas, $e);
      }
   }

   function createFromForm($title, $textColor, $backgroundColor, $backgroundPattern, $rank, $id) {
      $this->title = $title;
      $this->textColor = $textColor;
      $this->backgroundColor = $backgroundColor;
      $this->backgroundPattern = $backgroundPattern;
      $this->rank = $rank;
      $this->id = $id;
   }

   function toSectionForm() {
      $content = file_get_contents('../view/asset/sectionSkeleton.html');

      $content = str_replace('<SECTIONID>', $this->id, $content);
      $content = str_replace('<SECTIONRANK>', $this->rank, $content);

      // Title
      $content = str_replace('<TITLE>', $this->title, $content);

      // Top link
      if ($this->toplink != null) {
         $content = str_replace('<ISTOPLINK>', 'checked', $content);
         $content = str_replace('<TOPLINK>', $this->toplink->label, $content);
         $content = str_replace('<ISTOPLINKHIDDEN>', '', $content);
      } else {
         $content = str_replace('<ISTOPLINK>', '', $content);
         $content = str_replace('<TOPLINK>', '', $content);
         $content = str_replace('<ISTOPLINKHIDDEN>', 'hidden', $content);
      }

      // Miniature
      if ($this->miniature != null) {
         $content = str_replace('<ISMINIATURE>', 'checked', $content);
         $content = str_replace('<ISMINIATUREHIDDEN>', '', $content);
         $tmp = "<p id='curMiniature'>" . $this->miniature->upload->initialName . "</p>";
         $content = str_replace('<MINIATUREIMAGE>', $tmp, $content);
         $content = str_replace('<MINIATUREUPLOADID>', $this->miniature->upload->id, $content);
      } else {
         $content = str_replace('<ISMINIATURE>', '', $content);
         $content = str_replace('<ISMINIATUREHIDDEN>', 'hidden', $content);
         $content = str_replace('<MINIATUREUPLOADID>', '-1', $content);
      }

      // Background color
      $content = str_replace('<BACKGROUNDCOLOR>', $this->backgroundColor, $content);
      // Font color
      $content = str_replace('<FONTCOLOR>', $this->textColor, $content);
      // Background pattern
      $content = str_replace('<BACKGROUNDPATTERN>', $this->backgroundPattern, $content);

      // Links, galleries ans textareas
      $sortedElems = $this->getSortedElements();
      $sectionContent = "";
      foreach($sortedElems as $curElem) {
         $sectionContent .= $curElem->toSectionForm();
      }
      $content = str_replace('<CONTENT>', $sectionContent, $content);

      return $content;
   }

   function createFromMenu($rank, $id) {
      $this->rank = $rank;
      $this->id = $id;
   }

   function toMenuForm() {
      $content = file_get_contents('../view/asset/section.html');
      $content = str_replace('<ID>', $this->id, $content);
      $content = str_replace('<TITLE>', $this->title, $content);
      return $content;
   }

   function toSQL() {
      $q = "INSERT INTO adm_section(id, title, textColor, backgroundColor, backgroundPattern, rank)" 
         . "VALUES('" . $this->id . "', '" . $this->title . "', '" . $this->textColor . "', '" . $this->backgroundColor . "', '" . $this->backgroundPattern . "', '" . $this->rank . "'); ";
      
      if ($this->toplink != null) {
         $q .= $this->toplink->toSQL();
      }
      if ($this->miniature != null) {
         $q .= $this->miniature->toSQL();
      }

      foreach($this->links as $e) {
         $q .= $e->toSQL();
      }
      foreach($this->galleries as $e) {
         $q .= $e->toSQL();
      }
      foreach($this->textareas as $e) {
         $q .= $e->toSQL();
      }

      return $q;
   }

   function toWebsite() {
      $content = file_get_contents('../../assets/html_chuncks/section.html');
      $content = str_replace('<REF>', $this->id, $content);
      $content = str_replace('<STYLE>', $this->getPattern() . " color: " . $this->textColor . ";", $content);
      $content = str_replace('<TITLE>', $this->title, $content);

      $elem = $this->getSortedElements();
      $elementContent = "";
      $linksAreaLeft = "";
      $linksAreaRight = "";
      $nbLinksInArea = 0;

      $count = 0;

      foreach($elem as $e) {
         if (strcmp(get_class($e), "Link") == 0) {
            if ($nbLinksInArea % 2 == 0) {
               $linksAreaLeft .= $e->toWebsite();
            } else {
               $linksAreaRight .= $e->toWebsite();
            }
            $nbLinksInArea ++;
         }
         if (strcmp(get_class($e), "Link") != 0 || $count+1 == sizeof($elem)) {
            if ($nbLinksInArea > 0) {
               $linksArea = file_get_contents('../../assets/html_chuncks/linksArea.html');
               $linksArea = str_replace('<LINKS_LEFT>', $linksAreaLeft, $linksArea);
               $linksArea = str_replace('<LINKS_RIGHT>', $linksAreaRight, $linksArea);
               $elementContent .= $linksArea;

               $linksAreaLeft = "";
               $linksAreaRight = "";
               $nbLinksInArea = 0;
            }
            if (strcmp(get_class($e), "Link") != 0)
               $elementContent .= $e->toWebsite();
         }
         $count ++;
      }

      $content = str_replace('<CONTENT>', $elementContent, $content);
      return $content;
   }

   function getPattern() {
      $pattern = file_get_contents('../view/patterns/' . $this->backgroundPattern . '.css');
      $pattern = str_replace('<BG-COLOR>', $this->backgroundColor, $pattern);
      $pattern = str_replace('<FONT-COLOR>', $this->textColor, $pattern);
      return $pattern;
   }

   function delete($removeUploads) {
      if ($this->miniature != null)
         $this->miniature->delete($removeUploads);
      if ($this->toplink != null)
         $this->toplink->delete();
      foreach ($this->links as $e) {
         $e->delete($removeUploads);
      }
      foreach ($this->galleries as $e) {
         $e->delete($removeUploads);
      }
      foreach ($this->textareas as $e) {
         $e->delete();
      }
      $q = "DELETE FROM adm_section WHERE id='" . $this->id . "'; ";
      executeQuery($q);
   }

   function rankUpdate() {
      return "UPDATE adm_section SET rank = '" . $this->rank . "' WHERE id = '" . $this->id . "'; ";
   }

   function getSortedElements() {
      $sortedElems = array();
      $curRank = 0;
      do {
         $isElemFound = false;
         foreach ($this->galleries as $e) {
            if ($e->rank == $curRank) {
               array_push($sortedElems, $e);
               $isElemFound = true;
               break;
            }
         }
         if (!$isElemFound) {
            foreach ($this->textareas as $e) {
               if ($e->rank == $curRank) {
                  array_push($sortedElems, $e);
                  $isElemFound = true;
                  break;
               }
            }
         }
         if (!$isElemFound) {
            foreach ($this->links as $e) {
               if ($e->rank == $curRank) {
                  array_push($sortedElems, $e);
                  $isElemFound = true;
                  break;
               }
            }
         }
         $curRank ++;
      } while($isElemFound);
      return $sortedElems;
   }
 }
?>