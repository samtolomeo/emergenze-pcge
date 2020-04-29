<?php 

$subtitle="Sottotitolo pagina"


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="roberto" >

    <title>Gestione emergenze</title>
<?php 
require('./req.php');

require(explode('emergenze-pcge',getcwd())[0].'emergenze-pcge/conn.php');

require('./check_evento.php');
?>

<!--link rel="stylesheet" href="l_map/css/leaflet.css"-->
<!--link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css"-->
	<link rel="stylesheet" href="l_map/css/L.Control.Locate.min.css">
   <link rel="stylesheetl_map/" href="l_map/css/qgis2web.css">
   <link rel="stylesheet" href="l_map/css/MarkerCluster.css">
   <link rel="stylesheet" href="l_map/css/MarkerCluster.Default.css">
   <link rel="stylesheet" href="l_map/css/leaflet-measure.css">
        <style>
        html, body, #map {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }
        </style>
        <title></title>


</head>

<body>


        <?php 
            //require('./navbar_up.php')
        ?>  
        <?php 
            //require('./navbar_left.php')
        ?> 
            

 




        <div id="map">
        </div>
        
        
        
        <?php 

//require('./footer.php');

require('./req_bottom.php');


	

?>


        <script src="l_map/js/qgis2web_expressions.js"></script>
        <!--script src="js/leaflet.js"></script><script src="js/L.Control.Locate.min.js"></script-->
        <script src="l_map/js/leaflet-svg-shape-markers.min.js"></script>
        <script src="l_map/js/leaflet.rotatedMarker.js"></script>
        <script src="l_map/js/leaflet.pattern.js"></script>
        <script src="l_map/js/leaflet-hash.js"></script>
        <script src="l_map/js/Autolinker.min.js"></script>
        <script src="l_map/js/rbush.min.js"></script>
        <script src="l_map/js/labelgun.min.js"></script>
        <script src="l_map/js/labels.js"></script>
        <script src="l_map/js/leaflet-measure.js"></script>
        <script src="l_map/js/leaflet.markercluster.js"></script>
        <!--script src="l_map/data/v_segnalazioni_0.js"></script-->
        <script>
        var highlightLayer;
        function highlightFeature(e) {
            highlightLayer = e.target;

            if (e.target.feature.geometry.type === 'LineString') {
              highlightLayer.setStyle({
                color: '#ffff00',
              });
            } else {
              highlightLayer.setStyle({
                fillColor: '#ffff00',
                fillOpacity: 1
              });
            }
        }
        /*var map = L.map('map', {
            zoomControl:true, maxZoom:28, minZoom:1
        }).fitBounds([[44.4069527187,8.86036251006],[44.4847013265,8.96496972789]]);*/
        
        
        	var map = L.map('map').setView([44.441266, 8.912661], 12);
        
        
        var hash = new L.Hash(map);
        //map.attributionControl.addAttribution('<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a>');
        
        //L.control.locate().addTo(map);
        
        
        
        var measureControl = new L.Control.Measure({
            primaryLengthUnit: 'meters',
            secondaryLengthUnit: 'kilometers',
            primaryAreaUnit: 'sqmeters',
            secondaryAreaUnit: 'hectares'
        });
        measureControl.addTo(map);
        
        
        
        var bounds_group = new L.featureGroup([]);
        /*var basemap0 = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors,<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
            maxZoom: 28
        });
        basemap0.addTo(map);
        var basemap1 = L.tileLayer('http://{s}.www.toolserver.org/tiles/bw-mapnik/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
            maxZoom: 28
        });
        basemap1.addTo(map);*/
        
        
        var basemap2 = L.tileLayer('http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors,<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>,Tiles courtesy of <a href="http://hot.openstreetmap.org/" target="_blank">Humanitarian OpenStreetMap Team</a>',
            maxZoom: 28
        });
        basemap2.addTo(map);
        
        /*var basemap3 = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	});
			basemap3.addTo(map);*/
        
        
        
        function setBounds() {
        }
        
        
        
        /*function pop_v_segnalazioni_0(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['descrizione'] !== null ? Autolinker.link(String(feature.properties['descrizione'])) : '') + '</td>\
                    </tr>\
                    <tr>\
                    		<td colspan="2">' + (feature.properties['criticita'] !== null ? Autolinker.link(String(feature.properties['criticita'])) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['rischio'] !== null ? Autolinker.link(String(feature.properties['rischio'])) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['note'] !== null ? Autolinker.link(String(feature.properties['note'])) : '') + '</td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }*/
        
        
        

        /*function style_v_segnalazioni_0_0() {
            return {
                pane: 'pane_v_segnalazioni_0',
                shape: 'diamond',
                radius: 6.0,
                opacity: 1,
                color: 'rgba(0,0,0,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(255,229,0,1.0)',
            }
        }*/
        /*map.createPane('pane_v_segnalazioni_0');
        map.getPane('pane_v_segnalazioni_0').style.zIndex = 400;
        map.getPane('pane_v_segnalazioni_0').style['mix-blend-mode'] = 'normal';*/
        /*var layer_v_segnalazioni_0 = new L.geoJson(json_v_segnalazioni_0, {
            attribution: '<a href=""></a>',
            pane: 'pane_v_segnalazioni_0',
            onEachFeature: pop_v_segnalazioni_0,
            pointToLayer: function (feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.shapeMarker(latlng, style_v_segnalazioni_0_0(feature));
            },
        });*/
        
        
        // GeoJson Example
        /*var someFeatures = [{
			    "type": "Feature",
			    "properties": {
			        "name": "Coors Field",
			        "show_on_map": true
			    },
			    "geometry": {
			        "type": "Point",
			        "coordinates": [-104.99404, 39.75621]
			    }
			}, {
			    "type": "Feature",
			    "properties": {
			        "name": "Busch Field",
			        "show_on_map": false
			    },
			    "geometry": {
			        "type": "Point",
			        "coordinates": [-104.98404, 39.74621]
			    }
			}];*/

        
        
        
        var segn_non_lav = [
        
        <?php 
        $query_g="SELECT id, ST_AsGeoJson(geom) as geo, rischio, criticita, descrizione, note FROM segnalazioni.v_segnalazioni WHERE id_lavorazione is null;";


			// GeoJson Postgis: {"type":"Point","coordinates":[8.90092674245687,44.4828501691802]}
			

    		$i=0;
			$result_g = pg_query($conn, $query_g);
	      while($r_g = pg_fetch_assoc($result_g)) {
				if ($i==0){ 
					echo '{"type": "Feature","properties": {"id":'.$r_g["id"].', "rischio": "';
					echo $r_g["rischio"].'", "criticita": "'.$r_g["criticita"].'", "descrizione": "'.str_replace('"',' ',$r_g["descrizione"]).'"},"geometry":';
					echo $r_g["geo"].'}';
				} else {
					//echo ",". $r_g["geo"];
					echo ',{"type": "Feature","properties": {"id":'.$r_g["id"].', "rischio": "';
					echo $r_g["rischio"].'", "criticita": "'.$r_g["criticita"].'", "descrizione": "'.str_replace('"',' ',$r_g["descrizione"]).'"},"geometry":';
					echo $r_g["geo"].'}';
					
				}
				$i=$i+1;
			}
			?>
			];
        
        
        
        var segn_lav = [
        
        <?php 
        $query_g="SELECT id, ST_AsGeoJson(geom) as geo, rischio, criticita, descrizione, note FROM segnalazioni.v_segnalazioni WHERE id_lavorazione > 0 and in_lavorazione='t';";


			// GeoJson Postgis: {"type":"Point","coordinates":[8.90092674245687,44.4828501691802]}
			

    		$i=0;
			$result_g = pg_query($conn, $query_g);
	      while($r_g = pg_fetch_assoc($result_g)) {
				if ($i==0){ 
					echo '{"type": "Feature","properties": {"id":'.$r_g["id"].', "rischio": "';
					echo $r_g["rischio"].'", "criticita": "'.$r_g["criticita"].'", "descrizione": "'.str_replace('"',' ',$r_g["descrizione"]).'"},"geometry":';
					echo $r_g["geo"].'}';
				} else {
					//echo ",". $r_g["geo"];
					echo ',{"type": "Feature","properties": {"id":'.$r_g["id"].', "rischio": "';
					echo $r_g["rischio"].'", "criticita": "'.$r_g["criticita"].'", "descrizione": "'.str_replace('"',' ',$r_g["descrizione"]).'"},"geometry":';
					echo $r_g["geo"].'}';
					
				}
				$i=$i+1;
			}
			?>
			];

			/*var myStyle = {
			    color: 'red',
				fillColor: '#f03',
				fillOpacity: 0
			};
			
			
			L.geoJSON(geojsonFeature, {
			    style: myStyle
			}).addTo(map);*/
        
        
        var stile_non_lavorazione = {
		    radius: 8,
		    fillColor: "#FFD700",
		    color: "#000",
		    weight: 1,
		    opacity: 1,
		    fillOpacity: 0.8
		};
		
		var stile_lavorazione = {
		    radius: 8,
		    fillColor: "#228B22",
		    color: "#000",
		    weight: 1,
		    opacity: 1,
		    fillOpacity: 0.8
		};
		/*var layer_v_segnalazioni_0 = new L.geoJson(geojsonFeature, {
		    pointToLayer: function (feature, latlng) {
		        return L.circleMarker(latlng, geojsonMarkerOptions);
		    }
		}).addTo(map);*/
        
        
        //var markers0 = L.markerClusterGroup();
        var markers1 = L.markerClusterGroup();   
		  
		  var layer_v_segnalazioni_0 = L.geoJson(segn_non_lav, {
		    pointToLayer: function (feature, latlng) {
		        return L.circleMarker(latlng, stile_non_lavorazione);
		    }
		    ,
			onEachFeature: function (feature, layer) {
				layer.bindPopup('<div align="right" style="color:grey"><i class="fas fa-pause-circle"></i> Da prendere in carico </div>'+
				'<h4><b>Tipo</b>: '+
				feature.properties.criticita+'</h4>'+
				'<a class="btn btn-primary active" role="button" target="_new" href="./dettagli_segnalazione.php?id='+
				feature.properties.id +
				'"> Dettagli segnalazione </a>' );
			}
		});
		
		var layer_v_segnalazioni_1 = L.geoJson(segn_lav, {
		    pointToLayer: function (feature, latlng) {
		        return L.circleMarker(latlng, stile_lavorazione);
		    }
		    ,
			onEachFeature: function (feature, layer) {
				layer.bindPopup('<div align="right" style="color:grey"><i class="fas fa-play-circle"></i> In lavorazione </div>'+
				'<h4><b>Tipo</b>: '+
				feature.properties.criticita+'</h4>'+
				'<a class="btn btn-primary active" role="button" target="_new" href="./dettagli_segnalazione.php?id="'+
				feature.properties.id +
				'"> Dettagli segnalazione </a>' );
			}
		});
		
		
		//markers0.addLayer(layer_v_segnalazioni_0);
		//map.addLayer(markers0);
		map.addLayer(layer_v_segnalazioni_0);
		
		markers1.addLayer(layer_v_segnalazioni_1);
		map.addLayer(markers1);
		
    
        
        
        
        
        
        
        var baseMaps = {/*'OSM': basemap0, 'OSM B&W': basemap1,*/ 'Humanitarian OpensStreetMap': basemap2/*, 'OSM-Mapbox': basemap3*/};
        
        //legenda
        L.control.layers(baseMaps,
        {'Segnalazioni non ancora in lavorazione': layer_v_segnalazioni_0,
        'Segnalazioni in lavorazione': markers1}
        ,
        {collapsed:true}
        ).addTo(map);
        
        setBounds();
        </script>







            
            <!-- /.row -->
    <!--/div-->
    <!-- /#wrapper -->




    

</body>

</html>
