<?php


class AreaChart extends TElement{

private $data;

public function __construct(){

parent::__construct('div');

$this->id = 'AreaChart'.uniqid();
$this->width = '900';
$this->height = '500';

}

public function show(){




$code = '  google.load("visualization", "1", {packages:["corechart"]});';

  $code  .=    "google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2013',  1000,      400],
          ['2014',  1170,      460],
          ['2015',  660,       1120],
          ['2016',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('$this->id'));
        chart.draw(data, options);
      }
";
$scriptApi = new TElement('script');
$scriptApi->type = 'text/javascript';
$scriptApi->src = "https://www.google.com/jsapi";


$script = new TElement('script');
$script->type = 'text/javascript';

$script->add($code);

parent::add($scriptApi);
parent::add($script);

parent::show();
}
}
?>