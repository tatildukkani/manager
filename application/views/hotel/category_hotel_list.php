<?php if(!empty($results[0]['attrs']['name'])){ ?>  
<ul class="media-list"> 
										<?php for($i=0; $i<count($results); $i++){ ?>
										<li class="media"> 
											<div class="media-left media-middle">
												<span class="btn bg-teal-400 btn-rounded btn-icon btn-xs">
															<span class="letter-icon"><?php print $results[$i]['attrs']['name'][0]; ?></span>
												</span>
											</div>

											<div class="media-body">
												<div class="media-heading text-semibold"><?php print $results[$i]['attrs']['name']; ?></div>
												<span class="text-muted"><?php print $results[$i]['attrs']['description']; ?></span>
											</div>

											<div class="media-right media-middle">
												<ul class="icons-list icons-list-extended text-nowrap">
							                    	<li><a href="javascript:void(0);" onClick="hotel_add('<?php print $results[$i]['attrs']['hid']; ?>','<?php print $results[$i]['attrs']['name']; ?>','<?php print $results[$i]['attrs']['description']; ?>');"><i class=" icon-plus2"></i></a></li>
							                    
						                    	</ul>
											</div> 
										</li>
										<?php } ?>
										
									</ul>
<?php } ?>