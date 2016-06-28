<a href="javascript:void(0)" onClick="goster();" id="goster_btn"><span class=" icon-three-bars"></span> Arama Sonuçlarını Göster</a>

<h2><?php print $results[0]['attrs']['name']; ?> <small><?php print $results[0]['attrs']['type']; ?></small></h2>
<!-- Summernote click to edit -->


<style>

#picture {
			width: 750px;
			height: 422px;
			background-color:#fbfbfb;
			position:relative; /* or fixed or absolute */
		}
</style>

<div class="row">
<div class="col-md-12"><div id="picture"></div>

<div id="picture_list"></div>
</div>
</div>
<h5>Açıklama: <small>Nereye gidilir, ne yenir?</small></h5>
  <div id="description"><?php if(!empty($destination['description'])){ print $destination['description']; } ?></div>
  
							
                            <?php if($results[0]['attrs']['type'] == 'country') { ?>
                            <h2>Vize Bilgisi</h2>
                            <div class="summernote" id="visa"><?php if(!empty($destination['visa'])){ print $destination['visa']; } ?></div>
                            <?php } else { ?>
                            <div style="display:none" id="visa"></div>
                            <?php } ?>
                            
                            
<div class="row" style="margin-top:30px;">
<div class="col-md-6">
									<div class="form-group">
										<label>Şehir Merkezi:</label>
										<input type="text" class="form-control" id="us3-address">
									</div>

								
								   

									<div class="form-group">
										<div id="us3" class="map-wrapper"></div>
									</div>
                                    
                                    
                                  
										<div class="row">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                        <label>Yarıçap</label>
										<input type="text" class="form-control" id="us3-radius" <?php if(empty($destination['radius'])){ ?> value="<?php print $destination['radius']; ?>"<?php } ?>>
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                          <div class="form-group">
                                          <label>Lat</label>
										<input type="text" class="form-control" id="us3-lat" <?php if(empty($destination['lat'])){ ?> value="<?php print $destination['lat']; ?>"<?php } ?>>
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Lon</label>
										<input type="text" class="form-control" id="us3-lon" <?php if(empty($destination['lng'])){ ?> value="<?php print $destination['lng']; ?>"<?php } ?>>
                                        </div>
                                        </div>
									</div>

									
   </div>
   
   <div class="col-md-6">
   
   
   										<div class="row">
                                          <div class="form-group">
                                        <label>Vimeo ID:</label>
										<input type="text" class="form-control" id="video" name="video"><span class="help-inline"><button type="button" onClick="videoAdd();" class="btn btn-primary">Video Kaydet <i class="icon-arrow-right14 position-right"></i></button></span>
                                        </div>
                                        <div id="video_result"></div>
                                        </div>
                                       
   
   
   </div>
   
   
   <div class="col-md-12 ">
   <button type="button" class="btn bg-teal-400" onClick="submitForm();">Kaydet <i class=" icon-checkmark position-right"></i></button> 
   </div>

</div>
                            
                            
                            
						
			
<!-- /summernote click to edit -->


<script>
var cropperOptions = 
{
	uploadUrl:'destination/upload',
	onAfterImgCrop:		function(){ picture_get() },
	cropUrl:'destination/crop?did=<?php  print $results[0]['attrs']['did']; ?>&type=<?php  print $results[0]['attrs']['type']; ?>',
}

var cropperHeader = new Croppic('picture',cropperOptions);
   $(document).ready(function() {
	$('#description').summernote({
    lang: 'tr-TR'
  });
	$('#us3').locationpicker({
		<?php if(!empty($destination['lat'])){ ?>
        location: {latitude: <?php print $destination['lat']; ?>, longitude: <?php print $destination['lng']; ?>}, 
		radius: <?php print $destination['radius']; ?>,
		<?php }   ?>
		
        scrollwheel: false,
        inputBinding: {
			radiusInput: $('#us3-radius'),
            latitudeInput: $('#us3-lat'),
            longitudeInput: $('#us3-lon'),
            locationNameInput: $('#us3-address')        
        },
        enableAutocomplete: true
    });
	
	$.get( "destination/pictures?did=<?php  print $results[0]['attrs']['did']; ?>&type=<?php  print $results[0]['attrs']['type']; ?>", function( data ) {
		$( "#picture_list" ).html( data );
	});	
	
	$.get( "destination/videos?did=<?php  print $results[0]['attrs']['did']; ?>&type=<?php  print $results[0]['attrs']['type']; ?>", function( data ) {
		$( "#video_result" ).html( data );
	});	
	
});



function videoAdd()
{
$( "#video_result" ).html('Yükleniyor...');
	$.get( "destination/videos?did=<?php  print $results[0]['attrs']['did']; ?>&type=<?php  print $results[0]['attrs']['type']; ?>&video="+$('#video').val(), function( data ) {
		$( "#video_result" ).html( data );
	});	
}

function picture_get()
{
	$( "#picture_list" ).html('Yükleniyor...');
	$.get( "destination/pictures?did=<?php  print $results[0]['attrs']['did']; ?>&type=<?php  print $results[0]['attrs']['type']; ?>", function( data ) {
		$( "#picture_list" ).html( data );
	});	
}

function picture_delete(picture)
{
	$( "#picture_list" ).html('Siliniyor...');
	$.get( "destination/pictures?did=<?php  print $results[0]['attrs']['did']; ?>&type=<?php  print $results[0]['attrs']['type']; ?>&del="+picture, function( data ) {
		$( "#picture_list" ).html( data );
	});	
}

function video_delete(id)
{
	$( "#video_result" ).html('Siliniyor...');
	$.get( "destination/videos?did=<?php  print $results[0]['attrs']['did']; ?>&type=<?php  print $results[0]['attrs']['type']; ?>&del="+id, function( data ) {
		$( "#video_result" ).html( data );
	});	
}


function picture_head(picture)
{
	$( "#picture_list" ).html('Güncelleniyor...');
	$.get( "destination/pictures?did=<?php  print $results[0]['attrs']['did']; ?>&type=<?php  print $results[0]['attrs']['type']; ?>&head="+picture, function( data ) {
		$( "#picture_list" ).html( data );
	});	
}

	function submitForm()
	{
		

		var description  = $('#description').code();
		var visa  		= ''; 
		var lat         = $('#us3-lat').val();
		var lng         = $('#us3-lon').val();
		var radius      = $('#us3-radius').val();
		var formData    = "description="+description+"&visa="+visa+"&lat="+lat+"&lng="+lng+"&radius="+radius;
		$.ajax({
            type: 'POST',
            url: "destination/update?did=<?php  print $results[0]['attrs']['did']; ?>&type=<?php  print $results[0]['attrs']['type']; ?>",
            data: formData,
            success: function (data){
				alert('BAŞARIYLA KAYDEDİLDİ!');
            }
        });
	}
	

</script>