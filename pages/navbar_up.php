<?php 

require ('./note_ambiente.php');

?>

<style>
.dropdown-menu > li > a {
  white-space: normal;
}
</style>



<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--a class="navbar-brand" href="index.php"> </a-->
                <div class="navbar-brand"> <i class="fas fa-server"></i>
                Gestione emergenze <?php echo $note_ambiente?> - <?php echo $subtitle?> </div>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                
				
				 <li class="nav-item active">
					<a class="nav-link" href="index.php"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a>
				</li>
				
				
				<?php
					if($check_evento==0) {
				?>		

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-circle fa-fw"></i> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Nessun evento in corso</strong>
                                    <span class="pull-right text-muted">
                                        <em>...</em>
                                    </span>
                                </div>
                                <div>Nessun evento in corso</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="nuovo_evento.php">
                                <div>
                                    <strong>Crea nuovo evento</strong>
                                    <span class="pull-right text-muted">
                                        <em>Link</em>
                                    </span>
                                </div>
                                <div>Vai alla pagina di creazione eventi.</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        
                    </ul> </li>
                    <!-- /.dropdown-messages -->

				<?php		
					} else {
				?>
                <li class="dropdown">

                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    		<i class="fas fa-chevron-circle-down fa-fw"></i> <i class="fas fa-caret-down"></i>
                    		<i class="fas fa-circle fa-1x" style="color:<?php echo $color_allerta; ?>"></i> 
                    		<i class="fas fa-circle fa-1x" style="color:<?php echo $color_foc; ?>"></i>
                    </a>
                     
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="dettagli_evento.php">
                                <div>
                                <?php if( $descrizione_allerta!= 'Nessuna allerta') {?>
                                    <strong> Allerta <?php echo $descrizione_allerta; ?> in corso</strong>
                                 <?php } else { ?>
                                 	<strong> Nessuna allerta in corso</strong>
                                 <?php }  ?> 
                                    <span class="pull-right text-muted">
                                        <em><i class="fas fa-circle fa-1x" style="color:<?php echo $color_allerta; ?>"></i></em>
                                    </span>
                                </div>
                                <div> Clicca per visualizzare tutte le allerte in corso, previste o passate. </div>
                            </a>
                        </li>

                        <li class="divider"></li>
                        <li>
                            <a href="dettagli_evento.php">
                                <div>
                                    <?php if( $descrizione_foc!= '-') {?>
                                    <strong> Fase di <?php echo $descrizione_foc; ?> in corso</strong>
                                 <?php } else { ?>
                                 	<strong> Nessuna Fase Operativa in corso</strong>
                                 <?php }  ?> 
                                    <span class="pull-right text-muted">
                                        <em><i class="fas fa-circle fa-1x" style="color:<?php echo $color_foc; ?>"></i></em>
                                    </span>
                                </div>
                                <div> Clicca per visualizzare tutte le Fasi Operative Comunali in corso, previste o passate.</div>
                            </a>
                        </li>

                        <li class="divider"></li>
                        <li>
                            <a href="dettagli_evento.php">
                                <div>
                                <?php 
                                $len=count($eventi_attivi);	               
		               				if($len==1) {   
	               				   ?>
                                    <strong>Evento in corso</strong>
												<?php } else if ($len==0) { ?>
                                 	<strong>Nessun evento in corso</strong>
                                 <?php } else {
                                 	?>
                                 	<strong>Eventi in corso</strong>
                                 	<?php
                                 	}
                                 	?>
                                 	
                                    <span class="pull-right text-muted">
                                        <em><i class="fas fa-play"></i></em>
                                    </span>
                                </div>
                                <?php 
                                for ($i=0;$i<$len;$i++){
                                ?>
                                   - Tipo <?php echo $tipo_eventi_attivi[$i][1];?><br>
                                <?php
                                }
                                ?>
                                
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="dettagli_evento_c.php">
                                <div>
                                <?php 
                                $len_c=count($eventi_attivi_c);	               
		               				if($len_c==1) {   
	               				   ?>
                                    <strong>Evento in chiusura</strong>
                                 <?php } else if ($len_c==0) { ?>
                                 	<strong>Nessun evento in fase di chiusura</strong>
                                 <?php } else {
                                 	?>
                                 	<strong>Eventi in chiusura</strong>
                                 	<?php
                                 	}
                                 	?>
                                 	
                                    <span class="pull-right text-muted">
                                        <em><i class="fas fa-hourglass-end"></i></em>
                                    </span>
                                </div>
                                <?php 
                                for ($i=0;$i<$len_c;$i++){
                                ?>
                                   - Tipo <?php echo $tipo_eventi_c[$i][1];?><br>
                                <?php
                                }
                                ?>
                                
                            </a>
                        </li>
                        
                        
                        
                        
                        
                        <!--li class="divider"></li>
                        <li>
                            <a href="dettagli_evento.php">
                                <div>
                                    <strong>Dettagli</strong>
                                    <span class="pull-right text-muted">
                                        <em>Link</em>
                                    </span>
                                </div>
                                <div>Vai alla pagina con i dettagli degli eventi in corso per visualizzare e gestire anche tutte le allerte.</div>
                            </a>
                        </li>
                        <li class="divider"></li-->
                    </ul> </li>
                    <!-- /.dropdown-messages -->

				
				
				<?php		
					}
				?>


				
				<style>
				.fa-stack[data-count]:after{
				  position:absolute;
				  right:10%;
				  top:10%;
				  content: attr(data-count);
				  font-size:60%;
				  padding:.6em;
				  border-radius:999px;
				  line-height:.75em;
				  color: white;
				  background:rgba(255,0,0,.85);
				  text-align:center;
				  min-width:2em;
				  font-weight:bold;
				}
				</style>
				<?php if($segn_limbo>0){?>
					
					<li id="limbo" class="dropdown">
                    <!--a class="dropdown-toggle fa-stack fa-1x has-badge" data-count="4" data-toggle="dropdown" href="#"-->
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"-->
						<i class="fa fa-exclamation fa-fw" style="color:red"></i> <i class="fas fa-caret-down"></i>
                    </a>	
                    <ul class="dropdown-menu dropdown-alerts">
					<li>
						<a href="index.php#segn_limbo_table">
							<div>
								Nuove segnalazioni da elaborare!
							</div>
						</a>
					</li>
					</ul>
					</li>
					
				<?php }?>
				
				

				
                <li id="notifiche_profilo" class="dropdown" >
                    <!--a class="dropdown-toggle fa-stack fa-1x has-badge" data-count="4" data-toggle="dropdown" href="#"-->
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"-->
					<?php if ($count_resp >0) { ?>
						<i class="fas fa-bell fa-fw" style="color:#ff0000"></i> <?php echo $count_resp;?> <i class="fas fa-caret-down"></i>
					<?php } else { ?>	
                        <i class="fas fa-bell fa-fw"></i>  <i class="fas fa-caret-down"></i>
					<?php } ?>	
                    </a>	
                    <ul class="dropdown-menu dropdown-alerts" style="white-space: normal;">
					<li>
						<a href="#">
							<div>
								Notifiche <?php echo $descrizione_profilo;?>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
					<a href="#">
                                <div>
                                    <i class="fas fa-user-shield"></i> Incarichi
                                    <span class="pull-right text-muted small"><?php echo $i_assegnati_resp;?> non presi in carico</span>
								</div>                              
                                <?php
								for ($ii = 0; $ii < $i_assegnati_resp; $ii++) {
									echo "<br><a href=\"dettagli_incarico.php?id=".$id_i_assegnati_resp[$ii]."\">Descrizione: ".$descrizione_i_assegnati_resp[$ii]."</a>" ;
								}
								?>
                            
							</a>
                        </li>
                        <li class="divider"></li>
					<li>
					<a href="#">
                                <div>
                                    <i class="fas fa-user-tag"></i> Incarichi interni
                                    <span class="pull-right text-muted small"><?php echo $ii_assegnati_resp;?> non presi in carico</span>
								</div>                              
                                <?php
								for ($ii = 0; $ii < $ii_assegnati_resp; $ii++) {
									echo "<br><a href=\"dettagli_incarico_interno.php?id=".$id_ii_assegnati_resp[$ii]."\">Descrizione: ".$descrizione_ii_assegnati_resp[$ii]."</a>" ;
								}
								?>
                            
							</a>
                        </li>
                        <li class="divider"></li>
					<li>
					<a href="#">
                                <div>
                                    <i class="fas fa-pencil-ruler"></i> Presidi fissi
                                    <span class="pull-right text-muted small"><?php echo $s_assegnati_resp;?> non presi in carico</span>
								</div>                              
                                <?php
								for ($ii = 0; $ii < $s_assegnati_resp; $ii++) {
									echo "<br><a href=\"dettagli_sopralluogo.php?id=".$id_s_assegnati_resp[$ii]."\">Descrizione: ".$descrizione_s_assegnati_resp[$ii]."</a>" ;
								}
								?>
                            
							</a>
                        </li>
                        
                        <li class="divider"></li>
                        
                        <li>
					<a href="#">
                                <div>
                                    <i class="fas fa-pencil-ruler"></i> Presidi mobili
                                    <span class="pull-right text-muted small"><?php echo $sm_assegnati_resp;?> non presi in carico</span>
								</div>                              
                                <?php
								for ($ii = 0; $ii < $sm_assegnati_resp; $ii++) {
									echo "<br><a href=\"dettagli_sopralluogo_mobile.php?id=".$id_sm_assegnati_resp[$ii]."\">Descrizione: ".$descrizione_sm_assegnati_resp[$ii]."</a>" ;
								}
								?>
                            
							</a>
                        </li>
                        
                        
                        <li class="divider"></li>
                    <li>
					<a href="#">
                                <div>
                                    <i class="fas fa-exclamation-triangle"></i> Provv. cautelari
                                    <span class="pull-right text-muted small"><?php echo $pc_assegnati_resp;?> non presi in carico</span>
								</div>                              
                                <?php
								for ($ii = 0; $ii < $pc_assegnati_resp; $ii++) {
									echo "<br><a href=\"dettagli_provvedimento_cautelare.php?id=".$id_pc_assegnati_resp[$ii]."\">Tipo: ".$tipo_pc_assegnati_resp[$ii]."</a>" ;
								}
								?>
                            
							</a>
                        </li>
						<li class="divider"></li>
                        <li>
                            <a class="text-center" href="index.php#panel-notifiche">
                                <strong>Vedi tutti i conteggi</strong>
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
				
				<li id="notifiche_squadra" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php if ($count_squadra >0) { ?>
						<i class="fas fa-users" style="color:#ff0000"></i> <?php echo $count_squadra;?> <i class="fas fa-caret-down"></i>
					<?php } else { ?>	
                        <i class="fas fa-users"></i>  <i class="fas fa-caret-down"></i>
					<?php } ?>	
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
					<li>
						<a href="#">
							<div>
								Notifiche squadra <?php echo $nome_squadra_operatore;?>
							</div>
						</a>
					</li>

                        <li class="divider"></li>
					<li>
					<a href="#">
                                <div>
                                    <i class="fas fa-user-tag"></i> Incarichi interni
                                    <span class="pull-right text-muted small"><?php echo $ii_assegnati_squadra;?></span>
								</div>                              
                                <?php
								for ($ii = 0; $ii < $ii_assegnati_squadra; $ii++) {
									echo "<br><a href=\"dettagli_incarico_interno.php?id=".$id_ii_assegnati_squadra[$ii]."\">Vai ai dettagli</a>" ;
								}
								?>
                            
							</a>
                        </li>
                        <li class="divider"></li>
					<li>
					<a href="#">
                                <div>
                                    <i class="fas fa-pencil-ruler"></i> Presidi
                                    <span class="pull-right text-muted small"><?php echo $s_assegnati_squadra;?></span>
								</div>                              
                                <?php
								for ($ii = 0; $ii < $s_assegnati_squadra; $ii++) {
									echo "<br><a href=\"dettagli_sopralluogo.php?id=".$id_ii_assegnati_squadra[$ii]."\">Tipo: ".$descrizione_ii_assegnati_squadra[$ii]."</a>" ;
								}
								?>
                            
							</a>
                        </li>
                        <li class="divider"></li>
                    <li>
					<a href="#">
                                <div>
                                    <i class="fas fa-exclamation-triangle"></i> Provv. cautelari
                                    <span class="pull-right text-muted small"><?php echo $pc_assegnati_squadra;?></span>
								</div>                              
                                <?php
								for ($ii = 0; $ii < $pc_assegnati_squadra; $ii++) {
									echo "<br><a href=\"dettagli_provvedimento_cautelare.php?id=".$id_pc_assegnati_squadra[$ii]."\">Tipo: ".$tipo_pc_assegnati_squadra[$ii]."</a>" ;
								}
								?>
                            
							</a>
                        </li>
                    </ul>
                </li>

				
				
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-user fa-fw"></i> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
						<li><a href="./profilo.php"><i class="fas fa-user fa-fw"></i> CF: <?php echo $CF;?> (Clicca per visualizzare i dettagli)</a>
                        </li>
                        <!--li><a href="./profilo.php"><i class="fas fa-user fa-fw"></i> User Profile</a>
                        </li-->
                        <!--li><a href="#"><i class="fas fa-gear fa-fw"></i> Settings (DEMO)</a>
                        </li-->
                        <li class="divider"></li>
                        <li><a href="https://gestemert.comune.genova.it/Shibboleth.sso/Logout"><i class="fas fa-sign-out fa-fw"></i>Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            
            

