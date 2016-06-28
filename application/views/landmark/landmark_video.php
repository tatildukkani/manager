<?php if(empty($videos[0]['video'])){ ?>
<div class="panel"> 

								<div class="panel-body">
									Henüz video yüklenmemiş. Yukarıdaki modülden video ekleyebilirsiniz.
								</div> 
							</div>
<?php } else { ?>
<div class="row" >


<?php for($i=0; $i<count($videos); $i++){ ?>

<div class="col-lg-4 col-sm-6">
							<div class="thumbnail">
								<div class="video-container">
									<iframe allowfullscreen="" frameborder="0" mozallowfullscreen="" src="https://player.vimeo.com/video/<?php print $videos[$i]['video']; ?>?title=0&amp;byline=0&amp;portrait=0" webkitallowfullscreen=""></iframe>
					            </div>
                                <div><a href="javascript:void(0);" onClick="video_delete('<?php print $videos[$i]['id']; ?>');">Sil</a></div>
							</div>
                            
</div>

<?php } ?>


</div> 


<?php } ?>