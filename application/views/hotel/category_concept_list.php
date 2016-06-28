<?php if(!empty($results[0]['attrs']['concept'])){ ?>  
<ul class="media-list"> 
										<?php for($i=0; $i<count($results); $i++){ ?>
										<li class="media"> 
											<div class="media-left media-middle">
												<span class="btn bg-teal-400 btn-rounded btn-icon btn-xs">
															<span class="letter-icon"><?php print $results[$i]['attrs']['concept'][0]; ?></span>
												</span>
											</div>

											<div class="media-body">
												<div class="media-heading text-semibold"><?php print $results[$i]['attrs']['concept']; ?></div>
											
											</div>

											<div class="media-right media-middle">
												<ul class="icons-list icons-list-extended text-nowrap">
							                    	<li><a href="javascript:void(0);" onClick="concept_add('<?php print $results[$i]['attrs']['cid']; ?>','<?php print $results[$i]['attrs']['concept']; ?>');"><i class=" icon-plus2"></i></a></li>
							                    
						                    	</ul>
											</div> 
										</li>
										<?php } ?>
										
									</ul>
<?php } ?>