<?php

require_once("database.php");
include "query_types.php";

$query_type = $_POST["query_type"];
$start_date_string = $_POST["start_date"];
$end_date_string = $_POST["end_date"];

if (array_key_exists($query_type, $query_types))
{
	$database = new Database__Query("DATABASE");
	foreach($query_types[$query_type]["sql_clauses"] as $clause)
	{
		$database->add_clause($clause);
	}

	$database->add_clause("date > UNIX_TIMESTAMP('" . $start_date_string . "')");
	$database->add_clause("date < UNIX_TIMESTAMP('" . $end_date_string . "')");

	$database->set_grouping($query_types[$query_type]["sql_grouping"]);
	$database->set_order($query_types[$query_type]["sql_order"]);
	$database->query($query_types[$query_type]["sql_statement"]);
	$rows = $database->get_all_rows();

	$data = array();

	foreach ($rows as $row)
	{
		$value = $row["value"];
		$time = round($row["time"]);
			
		$temparray = array("x" => ((int)$time) * 1000, "y" => (int)$value);

		array_push($data, $temparray);
	}

	echo json_encode($data);
}
else
{
	echo json_encode(false);
}

?>
