<?php
     //Part C
     require_once ("MiniTemplator.class.php");
     include 'config.php';
     include('db.php');
     include('validation.php')

    function getWine(){
        
        // Database connection
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);

        // Reading the form data
        // $wineName = isset($_GET['formWine']) ? $_GET['formWine'] : '';
        // $wineryName = isset($_GET['formWinery']) ? $_GET['formWinery'] : '';
        // $regionName = isset($_GET['formRegion']) ? $_GET['formRegion'] : '';  
        // $variety = $_GET['formVariety'];
        // $fromYear = $_GET['fromYear'];
        // $toYear = $_GET['toYear'];
        // $stock = $_GET['formStock'];
        // $order = $_GET['formOrder'];
        // $minCost = $_GET['minCost'];
        // $maxCost = $_GET['maxCost'];

        // Reading the form data
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

        $query="SELECT wine_name, variety, year, winery_name,region_name,cost, on_hand,sum(qty),sum(price)
                FROM wine,winery,region,grape_variety,wine_variety,inventory, items
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

      // Get the query
      return $con->query($query);
    }

    function generatePage() {
        
        validation();

        // Creating the template
        $t = new MiniTemplator;
        $t->readTemplateFromFile ("results_template.html");

        $rows = getWine();

        while ($row = mysqli_fetch_array($rows)){
               $t->setVariable('name', $row['wine_name']);
               $t->setVariable('variety', $row['variety']);
               $t->setVariable('year', $row['year']);
               $t->setVariable('winery', $row['winery_name']);
               $t->setVariable('region', $row['region_name']);
               $t->setVariable('cost', $row['cost']);
               $t->setVariable('stock', $row['on_hand']);
               $t->setVariable('item', $row['sum(qty)']);
               $t->setVariable('price', $row['sum(price)']);

               $t->addBlock("wine");
        }
            $t->generateOutput();
    }

generatePage();

?>
