<?php
      // PART D
      require_once ("MiniTemplator.class.php");
      include 'config.php';
      require_once('db.php');

      // Create the template
      $t = new MiniTemplator;
      $t->readTemplateFromFile ("search_template.html");

      // Connect to the database
      try {
            $dsn = DB_ENGINE .':host='. DB_HOST .';dbname='. DB_NAME;
            $db = new PDO($dsn, DB_USER, DB_PW);
      } 
      catch (DBOException $exception) {
             echo $exception->getMessage();
             exit; 
      }
  
      // Dropdown query for variety
      $query = "SELECT * FROM region ORDER BY region_name";

      foreach($db->query($query) as $row) {
          $regions = $row['region_name'];
          $t->setVariable ("regions",$regions); 
          $t->addBlock ("region"); 
      }

      // Dropdown query for region
      $query = "SELECT * FROM grape_variety ORDER BY variety";

      foreach($db->query($query) as $row) {
          $variety = $row['variety'];
          $t->setVariable ("variety",$variety); 
          $t->addBlock ("variety"); 
      }

      // Dropdown query for years
      $query = "SELECT DISTINCT year FROM wine ORDER BY year ASC";

      foreach($db->query($query) as $row) {
          $fromYear = $row['year'];
          $t->setVariable ("fromYear",$fromYear); 
          $t->addBlock ("fromYear"); 
      }

      // Dropdown query for years
      $query = "SELECT DISTINCT year FROM wine ORDER BY year DESC";

      foreach($db->query($query) as $row) {
          $toYear = $row['year'];
          $t->setVariable ("toYear",$toYear); 
          $t->addBlock ("toYear"); 
      }
    
  // Display the results
  $t->generateOutput();

?>