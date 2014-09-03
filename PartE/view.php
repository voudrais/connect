<?php

  // PART E
  require_once ("MiniTemplator.class.php");

  // Creating the template
  $t = new MiniTemplator;
  $t->readTemplateFromFile ("view_template.html");

  session_start();

  if(isset($_SESSION['views'])){
           $all = $_SESSION['views'];

     // Displaying the name
     $name = '<tr><td>Name</td></tr>';
     $t->setVariable('name', $name);
     $t-> addBlock("tableName");

     // Displaying the wine viewed
     foreach($all as $key => $value) {
        		 $wine = '<tr><td>' . $value . '</td></tr>';
             $t->setVariable('wine', $wine);
             $t-> addBlock("wineResults");
             }
  } 
  $t->generateOutput();    
?>