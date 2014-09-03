<?php
      // PART C
      require_once ("MiniTemplator.class.php");
      include 'config.php';
      require_once('db.php');

      // Create the template
      $t = new MiniTemplator;
      $t->readTemplateFromFile ("search_template.html");

      // Connect to the database
      $con = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);
  
      $regionData = mysqli_query($con,"SELECT * FROM region ORDER BY region_name");

      // Dropdown query for region
      while($row = mysqli_fetch_array($regionData)) {
            $regions = '<option value="' . $row['region_name'] . '">' .  $row['region_name'] . '</option>';
            $t->setVariable ("regions",$regions); 
            $t->addBlock ("region"); 
      }

      // Dropdown query for variety
      $varietyData = mysqli_query($con,"SELECT * FROM grape_variety ORDER BY variety");

      while($row = mysqli_fetch_array($varietyData)) {
            $variety = '<option value="' . $row['variety'] . '">' .  $row['variety'] . '</option>';
            $t->setVariable ("variety",$variety); 
            $t->addBlock ("variety"); 
      }

      // Dropdown query for years
      $yearData = mysqli_query($con,"SELECT DISTINCT year FROM wine ORDER BY year ASC");

      while($row = mysqli_fetch_array($yearData)) {
            $fromYear = '<option value="' . $row['year'] . '">' .  $row['year'] . '</option>';
            $t->setVariable ("fromYear",$fromYear); 
            $t->addBlock ("fromYear"); 
      }


      // Dropdown query for years
      $yearData = mysqli_query($con,"SELECT DISTINCT year FROM wine ORDER BY year DESC");

      while($row = mysqli_fetch_array($yearData)) {
            $toYear = '<option value="' . $row['year'] . '">' .  $row['year'] . '</option>';
            $t->setVariable ("toYear",$toYear); 
            $t->addBlock ("toYear"); 
      } 
    
      $t->generateOutput();
?>