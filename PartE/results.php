<?php
      // PART E
      require_once ("MiniTemplator.class.php");
      include 'config.php';
      include ('db.php');
      include ('validation.php');

      // Adding the session
      session_start();

      // Creating the template
      $t = new MiniTemplator;
      $t->readTemplateFromFile ("results_template.html");

      if (isset($_SESSION['views'])) {
      $button = "<button type=\"submit\" class=\"btn btn-primary\">End Session</button>";
      $t->setVariable('sessionButton', $button);
      $t-> addBlock("sessionButton");
      }

      if (isset($_SESSION['views'])) {  
      $button = "<button type=\"submit\" class=\"btn btn-primary\">Tweet</button>";
      $t->setVariable('tweetButton', $button);
      $t-> addBlock("tweetButton");
      }

      if (isset($_SESSION['views'])) {  
      $button = "<button type=\"submit\" class=\"btn btn-primary\">Previous Wines</button>";
      $t->setVariable('wineButton', $button);
      $t-> addBlock("wineButton");
      }
  
      // Connection to the database
      try {
            $dsn = DB_ENGINE .':host=' . DB_HOST .';dbname=' . DB_NAME;
            $db = new PDO($dsn, DB_USER, DB_PW);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } 
      catch (DBOException $exception) {
             echo $exception->getMessage();
             exit;
      }

        // Reading the form data
        // $wineName = $_GET['formWine'];
        // $wineryName = $_GET['formWinery'];
        // $regionName = $_GET['formRegion'];  
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


        // Destroying the session
        if (isset($_GET["session"])){
        $sessionStatus = $_GET["session"];

        if ($sessionStatus == 'stop') {
            $_SESSION['views'] = "";
            session_destroy();
            header('location:search.php');

          }       
        }

      // Query to display the wines based on form submission
      $query="SELECT wine_name, variety, year, winery_name, region_name, cost, on_hand, sum(qty), sum(price)
              FROM wine,winery,region,grape_variety,wine_variety,inventory,items
              WHERE wine.winery_id = winery.winery_id
              AND winery.region_id = region.region_id
              AND wine_variety.variety_id = grape_variety.variety_id
              AND wine.wine_id = wine_variety.wine_id
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

      validation();

      $result = $db->query($query); 
      $data = $db->query($query); 

      $stored = $data->fetchAll(PDO::FETCH_ASSOC);


      $add = "Attention: search was unable to find any matching wines in the database\n";
      if (!$stored) {
        $t->setVariable ('error', $add);
        $t->addBlock ("error");
        $t->generateOutput(); 
        exit;
      }

      if (isset($_SESSION['views'])) {
      foreach ($result as $row) {
      array_push($_SESSION['views'], $row['wine_name']);
        }
      }

      // Storing the query result
      $result = $db->query($query); 

      // Adding to the table block
      $table = "<table class=\"table table-striped\">
        <tr>
            <td align=\"left\">Name</td>
            <td align=\"left\">Variety</td>
            <td align=\"center\">Year</td>
            <td align=\"left\">Winery</td>
            <td align=\"left\">Region</td>
            <td align=\"right\">Cost</td>
            <td align=\"right\">Available</td>
            <td align=\"right\">Stock Sold</td>
            <td align=\"right\">Sales Revenue</td>
        </tr>";  
        $t->setVariable('table', $table);
        $t->addBlock("table");


      // Adding to the wine block
      foreach ($result as $row) {

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
   
?>