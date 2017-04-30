<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/highcharts/js/highcharts.js"></script>
<script src="js/highcharts/js/modules/exporting.js"></script>
<script src='js/gridster/jquery.gridster.min.js' type='text/javascript' charset='utf-8'></script>
<link rel='stylesheet' type='text/css' href='js/gridster/jquery.gridster.min.css'>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="js/jquery-ui-1.8.16.custom.css" />
<script src="js/moment.min.js"></script>
<script src="js/js.cookie.js"></script>
<script src="js/themes/gray.js"></script>

<?php

include "query_types.php";

$columns = 4;
$rows_counter = 1;
$columns_counter = 1;

echo "
	<div class='filters'>
		<input type='text' name='beginDate' id='beginDate' class='datepicker inputs' placeholder='From'/>
		<input type='text' name='endDate' id='endDate' class='datepicker inputs' placeholder='To'/>
		<input type='button' value='Update' id='update' class='inputs'>
	</div>
	<div class='gridster'>
		<ul>";
			$total_items = count($query_types);
			$rows = ceil($total_items / $columns);
			foreach ($query_types as $key => $element)
			{
				echo "<li data-row='" . $rows_counter . "' data-col='" . $columns_counter . "' data-sizex='2' data-sizey='2'>
						<dragger>|||</dragger>
						<div class='chart' id='" . $key . "'>
						</div>
					</li>";
				if ($rows_counter < $rows)
				{
					$rows_counter++;
				}
				else
				{
					$rows_counter = 1;
					$columns_counter++;
				}
			}
echo "	</ul>
	</div>";

?>

<script>
var gridster;
$(function(){
	gridster = $('.gridster ul').gridster({
		widget_margins: [10, 10],
		widget_base_dimensions: [140, 140],
		autogrow_cols: true,
		resize: {
			enabled: true,
			stop: function(e, ui, $widget) {
				$widget.children("div").first().highcharts().reflow();
			}
		},
		draggable: {
			handle: 'dragger',
        }
	}).data('gridster');
	
	var startDate = moment().subtract(2, 'days');
	var startDatetime = startDate.format("YYYY/MM/DD hh:mm:ss");	
	var endDate = moment(); 
    var endDatetime = endDate.format("YYYY/MM/DD hh:mm:ss");
	$('#beginDate').val(startDatetime);
	$('#endDate').val(endDatetime);
	
	
	$('.datepicker').datetimepicker({
		showSecond: true,
		timeFormat: 'hh:mm:ss',
		dateFormat: 'yy/mm/dd'
	});
	
	$('#update').click(function() {
		update_all();
	});
});

function ajax_call_update(url, data, key)
{
	$.ajax({
		type : 'POST',
		url : url,
		data: data,
		success: function(returned_data)
		{
			while(window['chart_' + key].series.length > 0)
				window['chart_' + key].series[0].remove();
			window['chart_' + key].addSeries({color: 'rgba(24, 162, 231, 1)', animation: false, turboThreshold: 0, data: JSON.parse(returned_data)});
		}
	});
}

function update_all()
{
	start_date = $('#beginDate').val();
	end_date = $('#endDate').val();
	url = 'get_data.php';
	
	$.each( chart_keys, function( key, value ) {
		data = 'query_type=' + value + '&start_date=' + start_date + '&end_date=' + end_date;
		ajax_call_update(url, data, value);
	});
}

</script>

<script>

	$(function () {
	
		Highcharts.setOptions({
			global: {
				timezoneOffset: 5 * 60
			},
			credits: false
		});
	
	
		<?php
			$keys = Array();
			foreach ($query_types as $key => $element)
			{
				array_push($keys,$key);
				echo "
					chart_" . $key . " = new Highcharts.Chart({
						chart: {
							renderTo: '" . $key . "',
							type: 'line',
							zoomType: 'xy'
						},
						title: {
							text: '" . $element["chart_title"] . "'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							type: 'datetime'
						},
						yAxis: {
							title: {
								text: '" . $element["axis_label"] . "'
							}
						},
						tooltip: {

						},
						legend: {
							enabled: false
						},
						plotOptions: {
							column: {
								pointPadding: 0.2,
								borderWidth: 0
							}
						},
						series: [{
							name: '" . $element["axis_label"] . "',
							turboThreshold: 0,
							data: []
						}]
					});
				";
			}
			echo "chart_keys = " . json_encode($keys) . ";";
			echo "update_all();";
		?>
	
		
	
	});
	
	
	
	
</script>

<style>
	body {
		background-color: #333;
	}
	.gridster ul {
		list-style: none;
	}
	/* Gridster styles */
	.demo {
		margin: 3em 0;
		padding: 7.5em 0 5.5em;
		background: #004756;
	}
	.gridster {
		width: 90%;
		margin: 0 auto;
	}
	.gridster .gs-w {
		cursor: pointer;
		-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);
		box-shadow: 0 0 5px rgba(0,0,0,0.3);
	}
	.gridster .player {
		-webkit-box-shadow: 3px 3px 5px rgba(0,0,0,0.3);
		box-shadow: 3px 3px 5px rgba(0,0,0,0.3);
	}
	.gridster .gs-w.try {
		background-image: url(../img/sprite.png);
		background-repeat: no-repeat;
		background-position: 37px -169px;

	}
	.gridster .preview-holder {
		border: none!important;
		border-radius: 0!important;
		background: rgba(255,255,255,.2)!important;
	}
	.gridster li dragger {
        background: #999;
		display: block;
		font-size: 20px;
		line-height: normal;
		text-align: center;
	}
	.filters {
		width: 100%;
		text-align: center;
	}
	.ui-datepicker {
		z-index: 100000 !important;
	}
	.inputs {
		padding: 1px 5px;
		border-radius:5px;
	}
	.datepicker {
		width: 140px;
	}
	/* css for timepicker */
	.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
	.ui-timepicker-div dl { text-align: left; }
	.ui-timepicker-div dl dt { height: 25px; }
	.ui-timepicker-div dl dd { margin: -25px 10px 10px 65px; }
	.ui-timepicker-div td { font-size: 90%; }
	.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
	
	.chart {
		width:100%;
		height:95%;
		margin: 0 auto;
	}
	
</style>
