<?php if(empty($pictures[0]['picture'])){ ?>
<div class="panel" style="margin-top:30px; margin-bottom:30px;">

								<div class="panel-body">
									Henüz resim yüklenmemiş. Yukarıdaki modülden resim ekleyebilirsiniz.
								</div>
							</div>
<?php } else { ?>
<div class="row" style="margin-top:30px; margin-bottom:30px;">

<div class="col-md-3">
<img src="http://manage.tatildukkani.com/assets/data/destinations/<?php print $pictures[0]['picture']; ?>" width="100%">
<div><a href="javascript:void(0);" onClick="picture_delete('<?php print $pictures[0]['picture']; ?>');">Sil</a> </div>	
</div>

<div class="col-md-9">
<div class="row">
<?php for($i=1; $i<count($pictures); $i++){ ?>
<div class="col-md-2" style="margin-bottom:15px;">
	<img src="http://manage.tatildukkani.com/assets/data/destinations/<?php print $pictures[$i]['picture']; ?>" width="100%">
	<div><a href="javascript:void(0);" onClick="picture_delete('<?php print $pictures[$i]['picture']; ?>');">Sil</a>  <a href="javascript:void(0);"  onClick="picture_head('<?php print $pictures[$i]['picture']; ?>');" style="float:right">Manşet</a></div>
</div>
<?php } ?>
</div>
</div>

</div>


<?php } ?>