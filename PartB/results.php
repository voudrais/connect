<?php 
   // PART B
     include ('config.php');
     include ('db.php');
     include ('validation.php');

  function formQuery(){

    // Database connection
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);

    // Reading the form data
        // $wineName = $_GET['wine'];
        // $wineryName = $_GET['winery'];
        // $regionName = $_GET['region'];  
        // $variety = $_GET['variety'];
        // $fromYear = $_GET['fromYear'];
        // $toYear = $_GET['toYear'];
        // $stock = $_GET['stock'];
        // $order = $_GET['order'];
        // $minCost = $_GET['mincost'];
        // $maxCost = $_GET['maxcost'];

        // Reading the form data in variables
        $wineName = isset($_GET['formWine']) ? $_GET['formWine'] : '';
        $wineryName = isset($_GET['formWinery']) ? $_GET['formWinery'] : '';
        $regionName = isset($_GET['formRegion']) ? $_GET['formRegion'] : '';
        $variety = isset($_GET['formVariety']) ? $_GET['formVariety'] : '';
        $fromYear = isset($_GET['fromYear']) ? $_GET['fromYear'] : '';
        $toYear = isset($_GET['toYear']) ? $_GET['toYear'] : '';
        $stock = isset($_GET['formStock']) ? $_GET['formStock'] : '';
        $order = isset($_GET['formOrder']) ? $_GET['formOrder'] : '';
        $minCost = isset($_GET['minCost']) ? $_GET['minCost'] : '';
        $maxCost = isset($_GET['maxCost']) ? $_GET['maxCost'] : '';

    // Query to display the wines based on form submission
        $query="SELECT wine_name, variety, year, winery_name,region_name,cost, on_hand,sum(qty),sum(price)
                FROM wine,winery,region,grape_variety,wine_variety,inventory,items
                WHERE wine.winery_id = winery.winery_id
                AND winery.region_id = region.region_id
                AND wine.wine_id = wine_variety.wine_id
                AND wine_variety.variety_id = grape_variety.variety_id
                AND wine.wine_id = inventory.wine_id
                AND wine.wine_id = items.wine_id";

      
                // Adding to the query
                if (!empty($wineName)) {
                    $query .= " AND wine_name LIKE '{$wineName}'";
                }

                if (!empty($wineryName)){
                    $query .= " AND winery_name LIKE '{$wineryName}'";
                }      

                if (!empty($regionName) && $regionName != "All") {
                    $query .= " AND region_name = '{$regionName}'";
                }

                $query .= " AND variety = '{$variety}'";

                if (isset($fromYear) && isset($toYear)) {
                    $query .= " AND year BETWEEN '{$fromYear}' AND '{$toYear}'";
                }

                if (!empty($stock)) {
                    $query .= " AND '{$stock}' < on_hand";
                }
           
                if(!empty($_GET['minCost'])){
                $query .= " AND cost > '{$minCost}'";
                }

                if(!empty($_GET['maxCost'])){
                $query .= " AND cost < '{$maxCost}'";
                }

                // Adding by group
                $query .= " GROUP BY wine_name, variety, year, winery_name, region_name, cost";

                if (!empty($order)) {
                $query .= " HAVING sum(qty) >= '{$order}'";
                }   

          $test = mysqli_query($con,$query);

          $checkResponse = mysqli_fetch_array($test);
          if (!$checkResponse > 0) { 
             echo "Attention: search was unable to find any matching wines in the database\n";
             echo "<form action=\"search.php\" ><div class=\"form-group\"><div class=\"col-xs-10\">
             <button type=\"submit\" class=\"btn btn-primary\">Search</button></div></div></form>";
             die();
          }

      $formResponse = mysqli_query($con,$query);


        // Displaying the table heading 
      print 
            "<table class='table table-striped'>
            <tr>
            <td align=left> Name  </td>
            <td align=left> Variety </td>
            <td align=center> Year </td>
            <td align=left> Winery </td>
            <td align=left> Region </td>
            <td align=right> Cost </td>
            <td align=right> Available </td>
            <td align=right> Stock Sold </td>
            <td align=right> Sales Revenue </td>
            </tr>";

        // Printing the results from the query
        while ($row = mysqli_fetch_array($formResponse)) {
             print "\n<tr>\n\t<td align=left>{$row["wine_name"]}</td>" .
             "\n\t<td align=left>{$row["variety"]}</td>" .
             "\n\t<td align=center>{$row["year"]}</td>" .
             "\n\t<td align=left>{$row["winery_name"]}</td>" .
             "\n\t<td align=left>{$row["region_name"]}</td>" .
             "\n\t<td align=right>{$row["cost"]}</td>" .
             "\n\t<td align=right>{$row["on_hand"]}</td>" .
             "\n\t<td align=right>{$row["sum(qty)"]}</td>" .
             "\n\t<td align=right>{$row["sum(price)"]}</td>\n</tr>";
        } 
        print "</table>";
      // }
      
      // else { 
      //   echo "No wines fit the criteria";
      // }
      mysqli_close($con);
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>PART B</title>
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <style type="text/css">.extra-margin{ margin:50px; } </style>
</head>

<body>
  <?php validation();
        formQuery(); 
    ?>

        <form action="search.php" class="form-horizontal">
            <div class="form-group">
                <div class="col-xs-10">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
 </body>
</html>