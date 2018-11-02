<?php ?>


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
                Gestione emergenze - <?php echo $subtitle?> </div>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                             <li class="dropdown">
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


                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-envelope fa-fw"></i> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>DEMO</strong>
                                    <span class="pull-right text-muted">
                                        <em>To do</em>
                                    </span>
                                </div>
                                <div>E' una componente che si potrà utilizzare (da decidere)</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-tasks fa-fw"></i> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fas fa-comment fa-fw"></i> DEMO
                                    <span class="pull-right text-muted small">...</span>                              
                                <div> ancora da decidere se utilizzare qualcosa di simile  </div>
                            </div>
                            </a>
                        </li>
                        <li class="divider"></li>                        
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-bell fa-fw"></i> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                    <li>
                            <a href="#">
                                <div>
                                    <i class="fas fa-comment fa-fw"></i> DEMO
                                    <span class="pull-right text-muted small">...</span>                              
                                <div> ancora da decidere se utilizzare qualcosa di simile  </div>
                            </div>
                            </a>
                        </li>
                        <li class="divider"></li>                        
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fas fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fas fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fas fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fas fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fas fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-user fa-fw"></i> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fas fa-user fa-fw"></i> User Profile (DEMO)</a>
                        </li>
                        <li><a href="#"><i class="fas fa-gear fa-fw"></i> Settings (DEMO)</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fas fa-sign-out fa-fw"></i> Logout (DEMO - TBD Paolo Di Gioia e CED</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            
            

