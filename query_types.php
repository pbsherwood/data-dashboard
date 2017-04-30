<?php
/*

Examples:

$query_types = array(
				"temperature_raw" => array("chart_title" => "Temperature", "axis_label" => "Temp", "sql_statement" => "select id, temperature as value, date as time from data", "sql_clauses" => array("mod( id, 30) =0"), "sql_grouping" => "", "sql_order" => "time"),
				"temperature_avg_daily" => array("chart_title" => "Temperature (Avg/Day)", "axis_label" => "Temp", "sql_statement" => "select id, temperature as value, date as time from data", "sql_clauses" => array(), "sql_grouping" => "DATE(FROM_UNIXTIME(time))", "sql_order" => "time"),
				"temperature_avg_weekly" => array("chart_title" => "Temperature (Avg/Week)", "axis_label" => "Temp", "sql_statement" => "select id, temperature as value, date as time from data", "sql_clauses" => array(), "sql_grouping" => "week(FROM_UNIXTIME(time))", "sql_order" => "time"),
				"temperature_avg_monthly" => array("chart_title" => "Temperature (Avg/Month)", "axis_label" => "Temp", "sql_statement" => "select id, temperature as value, date as time from data", "sql_clauses" => array(), "sql_grouping" => "month(FROM_UNIXTIME(time))", "sql_order" => "time"),
				"pressure_raw" => array("chart_title" => "Pressure", "axis_label" => "Pressure", "sql_statement" => "select id, pressure as value, date as time from data", "sql_clauses" => array("mod( id, 30) =0"), "sql_grouping" => "", "sql_order" => "time"),
				"pressure_avg_daily" => array("chart_title" => "Pressure (Avg/Day)", "axis_label" => "Pressure", "sql_statement" => "select id, pressure as value, date as time from data", "sql_clauses" => array(), "sql_grouping" => "DATE(FROM_UNIXTIME(time))", "sql_order" => "time"),
				"pressure_avg_weekly" => array("chart_title" => "Pressure (Avg/Week)", "axis_label" => "Pressure", "sql_statement" => "select id, pressure as value, date as time from data", "sql_clauses" => array(), "sql_grouping" => "week(FROM_UNIXTIME(time))", "sql_order" => "time"),
				"pressure_avg_monthly" => array("chart_title" => "Pressure (Avg/Month)", "axis_label" => "Pressure", "sql_statement" => "select id, pressure as value, date as time from data", "sql_clauses" => array(), "sql_grouping" => "month(FROM_UNIXTIME(time))", "sql_order" => "time"),
				"humidity_raw" => array("chart_title" => "Humidity", "axis_label" => "Humidity", "sql_statement" => "select id, humidity as value, date as time from data", "sql_clauses" => array("mod( id, 30) =0"), "sql_grouping" => "", "sql_order" => "time"),
				"dewpoint_raw" => array("chart_title" => "Dewpoint", "axis_label" => "Dewpoint", "sql_statement" => "select id, dewpoint as value, date as time from data", "sql_clauses" => array("mod( id, 30) =0"), "sql_grouping" => "", "sql_order" => "time"),
				"light_raw" => array("chart_title" => "Light", "axis_label" => "Light", "sql_statement" => "select id, light as value, date as time from data", "sql_clauses" => array("mod( id, 30) =0"), "sql_grouping" => "", "sql_order" => "time")
			);
*/
			
$query_types = array();
?>