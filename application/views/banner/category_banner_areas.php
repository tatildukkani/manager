<?php if(!empty($list[0])){ ?>
<ul class="media-list"> 
										<?php for($i=0; $i<count($list); $i++){ ?>
										<li class="media"> 
											

											<div class="media-body">
												<div class="media-heading text-semibold"><?php print $list[$i]['area_name']; ?></div>
												
											</div>

											<div class="media-right media-middle">
												<ul class="icons-list icons-list-extended text-nowrap">
							                    	<li><a href="javascript:void(0);" onClick="area_del('<?php print $list[$i]['id']; ?>');"><i class="icon-minus2"></i></a></li>
							                    
						                    	</ul>
											</div> 
										</li>
										<?php } ?>
										
									</ul>
<?php } else { ?>
<div><strong>Banner hiçbir sayfaya eklenmemiştir.</strong></div>

<?php } ?>