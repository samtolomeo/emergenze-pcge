
<?php 
require('./mappa_leaflet_embedded0.php');
?>


        
        
        
        var baseLayers = {
        		'OpenStreetMap': basemap2, 
        		'Realvista e-geos': realvista,
        		'Sfondo comunale': base_genova
        	};
        
        var overlayLayers = {'<img src="icon/segn_no_lavorazione.png" width="20" height="24" alt=""> Segnalazioni da elaborare': layer_v_segnalazioni_0,
        '<img src="icon/segn_lavorazione.png" width="20" height="24" alt="">  Segnalazioni in lavorazione': markers1,
        '<img src="icon/segn_chiusa.png" width="20" height="24" alt="">  Segnalazioni chiuse': layer_v_segnalazioni_2,
        '<img src="icon/sopralluogo.png" width="20" height="24" alt="">  Altri presidi': presidi,
        '<img src="icon/elemento_rischio.png" width="20" height="24" alt=""> Provvedimenti cautelari':pc
        }
        
        //legenda
        L.control.layers(baseLayers,overlayLayers,
        {collapsed:false}
        ).addTo(map);
        
        setBounds();
        </script>


