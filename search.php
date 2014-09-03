

<?php 
	//PART B
	include 'config.php';
	require_once('db.php');
    include ('validation.php');


	// Dynamic dropdown function for wine region
	function regionQuery(){
		$con = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);
		$regionData = mysqli_query($con,"SELECT region_name FROM region");
		while($record = mysqli_fetch_array($regionData)){
			echo '<option value="' . $record['region_name'] . '">' .  $record['region_name'] . '</option>';
		}
		mysqli_close($con);
	}

	// Dynamic dropdown function for wine variety
	function varietyQuery(){
		$con = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);
		$varietyData = mysqli_query($con,"SELECT variety FROM grape_variety");
		while($record = mysqli_fetch_array($varietyData)){
			echo '<option value="' . $record['variety'] . '">' .  $record['variety'] . '</option>';
		}
		mysqli_close($con);
	}

	// Dynamic dropdown function for wine year
	function yearsFromQuery(){
		$con = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);
		$yearsData = mysqli_query($con,"SELECT DISTINCT year FROM wine ORDER BY year ASC");
		while($record = mysqli_fetch_array($yearsData)){
			echo '<option value="' . $record['year'] . '">' .  $record['year'] . '</option>';
		}
		mysqli_close($con);
	}

    function yearsToQuery(){
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);
        $yearsData = mysqli_query($con,"SELECT DISTINCT year FROM wine ORDER BY year DESC");
        while($record = mysqli_fetch_array($yearsData)){
            echo '<option value="' . $record['year'] . '">' .  $record['year'] . '</option>';
        }
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
    <div class="extra-margin">
        <form action="results.php" class="form-horizontal" id="form" name="form">
        
    <div class="form-group">
                <label class="control-label col-xs-2">Name</label>

                <div class="col-xs-10">
                    <input class="form-control" typet="text" name="formWine"><br>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">Winery</label>

                <div class="col-xs-10">
                    <input class="form-control" type="text" name="formWinery" ><br>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">Region</label>

                <div class="col-xs-10">
                    <select class="form-control" name="formRegion">
                    <?php regionQuery() ?>
                    </select></br>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">Variety</label>

                <div class="col-xs-10">
                    <select class="form-control" name="formVariety">
                    <?php varietyQuery() ?>
                    </select><br>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">Year</label>

                <div class="col-xs-10">
                    <select class="form-control" name="fromYear">
                    <?php yearsFromQuery() ?>
                    </select> <select class="form-control" name="toYear">
                    <?php yearsToQuery() ?>
                    </select><br>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">Stock</label>

                <div class="col-xs-10">
                    <input class="form-control" name="formStock" type="text"><br>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">Orders</label>

                <div class="col-xs-10">
                    <input class="form-control" name="formOrder" type="text"><br>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">Cost</label>

                <div class="col-xs-10">
                    <input class="form-control" name="minCost" type="text"><br>
                    <input class="form-control" name="maxCost" type="text"><br>
                </div>
            </div>

            <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
            </div>
        </form>
    </div>
</body>
</html>