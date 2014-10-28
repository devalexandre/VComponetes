<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 10/22/14
 * Time: 3:25 PM
 */

class PMaps {

private $de;
    private $para;
    private $map;

    function __construct() {



        include_once("lib/GoogleMap.php");
        include_once("lib/JSMin.php");




        $this->map = new GoogleMapAPI();
        $this->map->_minify_js = isset($_REQUEST["min"])?FALSE:TRUE;

        $this->map->disableSidebar();

    }

    public function makeMap(){
$DIRECTIONS_CONTAINER_ID = "map_directions";

$this->map->addDirections("Littleton, CO", "Englewood, CO", $DIRECTIONS_CONTAINER_ID, $display_markers=true);

      echo $this->map->getHeaderJS();
      echo  $this->map->getMapJS();

echo $this->map->printOnLoad();
    echo  $this->map->printMap();
     echo   "<div id='$DIRECTIONS_CONTAINER_ID'></div>";



    }

}