
<?php  if(!empty($vars[0])){ ?>
<h4>Değerler</h4>
<ul class="media-list"> 
										<?php for($i=0; $i<count($vars); $i++){ ?>
										<li class="media" style="margin-top:0px; margin-bottom:2px; border-bottom:solid; border-bottom-color:#efefef; border-bottom-width:1px;"> 
											

											<div class="media-body">
												<div class="media-heading text-semibold"><?php print $vars[$i]['description']; ?></div>
                                              
												
											</div>

											<div class="media-right media-middle">
												<ul class="icons-list icons-list-extended text-nowrap">
							                    	<li><a href="javascript:void(0);" onClick="var_del('<?php print $vars[$i]['id']; ?>','<?php print $vars[$i]['category_var']; ?>');"><i class="icon-minus2"></i></a></li>
							                    
						                    	</ul>
											</div> 
										</li>
										<?php } ?>
										
									</ul>
<?php } ?>



<?php  if(!empty($concepts[0])){ ?>
<h4>Konsept</h4>
<ul class="media-list"> 
										<?php for($i=0; $i<count($concepts); $i++){ ?>
										<li class="media" style="margin-top:0px; margin-bottom:2px; border-bottom:solid; border-bottom-color:#efefef; border-bottom-width:1px;"> 
											

											<div class="media-body">
												<div class="media-heading text-semibold"><?php print $concepts[$i]['concept']; ?></div>
                                              
												
											</div>

											<div class="media-right media-middle">
												<ul class="icons-list icons-list-extended text-nowrap">
							                    	<li><a href="javascript:void(0);" onClick="concept_del('<?php print $concepts[$i]['id']; ?>');"><i class="icon-minus2"></i></a></li>
							                    
						                    	</ul>
											</div> 
										</li>
										<?php } ?>
										
									</ul>
<?php } ?>



<?php  if(!empty($destinations[0])){ ?>
<h3>Bölge</h3>
<ul class="media-list"> 
										<?php for($i=0; $i<count($destinations); $i++){ ?>
										<li class="media" style="margin-top:0px; margin-bottom:2px; border-bottom:solid; border-bottom-color:#efefef; border-bottom-width:1px;"> 
											

											<div class="media-body">
												<div class="media-heading text-semibold"><?php print $destinations[$i]['destination']; ?></div>
                                                <span><?php print $destinations[$i]['destination_type']; ?></span>
												
											</div>

											<div class="media-right media-middle">
												<ul class="icons-list icons-list-extended text-nowrap">
							                    	<li><a href="javascript:void(0);" onClick="destination_del('<?php print $destinations[$i]['id']; ?>');"><i class="icon-minus2"></i></a></li>
							                    
						                    	</ul>
											</div> 
										</li>
										<?php } ?>
										
									</ul>
<?php } ?>





<?php /*echo '<pre>'; print_r($hotels); echo '</pre>'; */ if(!empty($hotels[0])){ ?>
<h3>Otel</h3>
<ul class="media-list"> 
										<?php for($i=0; $i<count($hotels); $i++){ ?>
										<li class="media" style="margin-top:0px; margin-bottom:2px; border-bottom:solid; border-bottom-color:#efefef; border-bottom-width:1px;"> 
											

											<div class="media-body">
												<div class="media-heading text-semibold"><?php print $hotels[$i]['hotel']; ?></div>
                                                <span><?php print $hotels[$i]['hotel_description']; ?></span>
												
											</div>

											<div class="media-right media-middle">
												<ul class="icons-list icons-list-extended text-nowrap">
							                    	<li><a href="javascript:void(0);" onClick="hotel_del('<?php print $hotels[$i]['id']; ?>');"><i class="icon-minus2"></i></a></li>
							                    
						                    	</ul>
											</div> 
										</li>
										<?php } ?>
										
									</ul>
<?php } ?>