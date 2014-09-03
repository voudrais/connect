<?php
  function validation(){
  $message="";

  if ($_GET['formWine'] !=''){
    if (preg_match('/[^a-z\s-]/i',$_GET['formWine'])){
      echo "Attention: a wine name can only contain letters";
      echo "<form action=\"search.php\" ><div class=\"form-group\"><div class=\"col-xs-10\">
            <button type=\"submit\" class=\"btn btn-primary\">Search</button></div></div></form>";
      exit;
    }
  }

  if ($_GET['formWinery'] !=''){
    if (preg_match('/[^a-z\s-]/i',$_GET['formWinery'])){
      echo "Attention: a winery name can only contain letters";
      echo "<form action=\"search.php\" ><div class=\"form-group\"><div class=\"col-xs-10\">
            <button type=\"submit\" class=\"btn btn-primary\">Search</button></div></div></form>";
      exit;
    }
  }

  if ($_GET['formStock'] !=''){
    if (!is_numeric($_GET['formStock'])){
      echo "Attention: stock can only be numeric";
       echo "<form action=\"search.php\" ><div class=\"form-group\"><div class=\"col-xs-10\">
             <button type=\"submit\" class=\"btn btn-primary\">Search</button></div></div></form>";

      exit;
    }
  }

  if ($_GET['formOrder'] !=''){
    if (!is_numeric($_GET['formOrder'])){
      echo "Attention: orders can only be numeric";
      echo "<form action=\"search.php\" ><div class=\"form-group\"><div class=\"col-xs-10\">
            <button type=\"submit\" class=\"btn btn-primary\">Search</button></div></div></form>";
      exit;
    }
  }

  if ($_GET['minCost'] !=''){
    if (!is_numeric($_GET['minCost'])){
      echo "Attention: Cost can only be numeric";
      echo "<form action=\"search.php\" ><div class=\"form-group\"><div class=\"col-xs-10\">
            <button type=\"submit\" class=\"btn btn-primary\">Search</button></div></div></form>";
      exit;
    }
  }

  if ($_GET['maxCost'] !=''){
    if (!is_numeric($_GET['maxCost'])){
      echo "Attention: Cost can only be numeric";
      echo "<form action=\"search.php\" ><div class=\"form-group\"><div class=\"col-xs-10\">
            <button type=\"submit\" class=\"btn btn-primary\">Search</button></div></div></form>";
      exit;
    }
  }

    // Checks whether the first year is earlier or older than the second year
    if ($_GET['toYear'] < $_GET['fromYear']){
        $message.="Attention: The second year entry needs to be later than the first input";
    
        print $message;
        echo "<form action=\"search.php\" ><div class=\"form-group\"><div class=\"col-xs-10\">
              <button type=\"submit\" class=\"btn btn-primary\">Search</button></div></div></form>";
        exit;
    }
 
  // Checks whether the minimum price is higher than the input for maximum price 
    if ((!empty($_GET['minCost'])) && (!empty($_GET['maxCost'])) && $_GET['minCost'] > $_GET['maxCost']){
         $message.="Attention: Maximum price needs to be higher than the minimum price\n";

         print $message;
         echo "<form action=\"search.php\"><div class=\"form-group\"><div class=\"col-xs-10\">
              <button type=\"submit\" class=\"btn btn-primary\">Search</button></div></div></form>";
         exit;
    }
  }
?>