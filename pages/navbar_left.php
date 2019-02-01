<?php 
# sidebar definition
?>



<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-stream fa-fw"></i> Gestione eventi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="nuovo_evento.php">Crea nuovo evento</a>
                                </li>
                                <li>
                                    <a href="dettagli_evento.php">Dettagli eventi in corso</a>
                                </li>
                                 <li>
                                    <a href="dettagli_evento_c.php">Dettagli eventi in fase di chiusura</a>
                                </li>
                                <li>
                                    <a href="bollettini_meteo.php">Lista bollettini</a>
                                </li>
                                <li>
                                    <a href="log_update.php">Log update GeoDataBase</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="#"><i class="fas fa-map-marked-alt"></i> Segnalazioni <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="nuova_segnalazione.php">Inserisci segnalazione</a>
                                </li>
                                <li>
                                    <a href="mappa_segnalazioni.php#12/44.441266/8.912661">Mappa delle segnalazioni</a>
                                </li>
                                <li>
                                    <a href="elenco_segnalazioni.php">Elenco delle segnalazioni 
                                    <br><small> (<i class="fas fa-play"></i>eventi in corso / <i class="fas fa-hourglass-half"></i> in chiusura)</small>
                                    </a>
                                </li>
                                <li>
                                    <a href="elenco_segnalazioni_ev_chiusi.php">Elenco storico delle segnalazioni
                                    <br><small> (<i class="fas fa-stop"></i>eventi chiusi)</small>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-pencil-ruler"></i> Sopralluoghi <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="nuovo_sopralluogo.php">Inserisci sopralluogo</a>
                                </li>
                                <li>
                                    <a href="mappa_segnalazioni.php#12/44.441266/8.912661">Mappa sopralluoghi</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-exclamation-triangle"></i> Provvedimenti cautelari <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="nuovo_pc_sgombero.php">Sgombero civici</a>
                                </li>
								<li>
                                    <a href="nuovo_pc_sottopasso.php">Interdizione accesso sottopassi</a>
                                </li>
								<li>
                                    <a href="nuovo_pc_strada.php">Chiusura strada</a>
                                </li>
								<li>
                                    <a href="elenco_pc.php">Elenco provvedimenti cautelari</a>
                                </li>
                                <!--li>
                                    <a href="mappa_segnalazioni.php">Mappa sopralluoghi</a>
                                </li-->
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="#"><i class="fa fa-address-book fa-fw"></i> Gestione utenti<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	  <li>
                                    <a href="gestione_squadre.php">Gestione squadre</a>
                                </li>
                                <li>
                                    <a href="lista_dipendenti.php">Permessi dipendenti</a>
                                </li>
                                <li>
                                    <a href="lista_volontari.php">Permessi utenti esterni</a>
                                </li>
                                <li>
                                    <a href="add_volontario.php">Aggiunta utenti esterni</a>
                                </li>
                                <li>
                                    <a href="lista_mail.php">Contatti a cui notificare incarichi</a>
                                </li>
								<li>
                                    <a href="rubrica.php">Rubrica Comune di Genova</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="rassegna_stampa.php"><i class="far fa-newspaper"></i> Rassegna stampa comunale </a>
                        </li>
                        
                    </ul>
                    
						<div style="text-align: center;">
						   <br>
                		<img class="nav nav-second-level" src="../img/pc_ge.png" width="65%" alt="">
                		<br>
                		
							<a href="http://www.ponmetro.it/" target="_blank">
                		<img class="nav nav-second-level" src="../img/pon_metro/Logo_PONMetro-1.png" width="50%" alt="">
                		</a>
                	</div>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

