<?php $this->load->view('global/header'); ?>
<style>

#picture {
			width: 750px;
			height: 422px;
			background-color:#fbfbfb;
			position:relative; /* or fixed or absolute */
		}
</style>
<body class="navbar-top">

	<!-- Main navbar -->
	
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<?php $this->load->view('global/sidebar'); ?>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-earth position-left"></i> Önemli Yer - <?php print $landmark['landmark']; ?></h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('landmark'); ?>"><i class="icon-earth position-left"></i> Önemli Yerler</a></li>
							<li class="active"><?php print $landmark['landmark']; ?></li>
						</ul>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

					<!-- Main charts -->
					<div class="row">
					
							
                     
                                        
                            
                            
						<div class="col-md-12" >
							<div class="panel panel-flat">
							
								
								<div class="panel-body">
                                
                                
                                 <div class="row" style="margin-bottom:30px;">
<div class="col-md-12"><div id="picture"></div>

<div id="picture_list"></div>
</div>
</div>                          
      
                                
                                
                                <div class="row">
                                <div class="col-md-4">
                                  <div class="form-group">
                                          <label>Önemli Yer</label>
										<input type="text" class="form-control" id="landmark" value="<?php print $landmark['landmark']; ?>">
                                        </div>
                                        </div>
                                        
                                         <div class="col-md-4">
                                  <div class="form-group">
                                          <label>URL</label>
										<input type="text" class="form-control" id="url" value="<?php print $landmark['url']; ?>">
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                          <div class="form-group">
                                          <label>Tür</label>
										<select class="form-control" id="type" name="type">
                                        <option value="">Seçiniz</option>
                                         <option <?php if($landmark['type'] == 'Restaurant'){ ?>selected<?php } ?> value="Restaurant">Restaurant</option>
                                         <option <?php if($landmark['type'] == 'Havaalanı'){ ?>selected<?php } ?> value="Havaalanı">Havaalanı</option>
                                         <option <?php if($landmark['type'] == 'Eğlence'){ ?>selected<?php } ?> value="Eğlence">Eğlence</option>
                                         <option <?php if($landmark['type'] == 'Müze / Ören Yeri'){ ?>selected<?php } ?> value="Müze / Ören Yeri">Müze / Ören Yeri</option>
                                         <option <?php if($landmark['type'] == 'Gezilecek Yer'){ ?>selected<?php } ?> value="Gezilecek Yer">Gezilecek Yer</option>
                                         <option <?php if($landmark['type'] == 'Tarihi Mekan'){ ?>selected<?php } ?> value="Tarihi Mekan">Tarihi Mekan</option>
                                         <option <?php if($landmark['type'] == 'Üniversite'){ ?>selected<?php } ?> value="Üniversite">Üniversite</option>
                                         <option <?php if($landmark['type'] == 'Fuar Alanı'){ ?>selected<?php } ?> value="Fuar Alanı">Fuar Alanı</option>
                                         <option <?php if($landmark['type'] == 'Sağlık'){ ?>selected<?php } ?> value="Sağlık">Sağlık</option>
                                        </select>
                                       
                                        </div>
                                        </div>   
									</div>

<label>Açıklama</label>
<div id="description"><?php if(!empty($landmark['description'])){ print $landmark['description']; } ?></div>
  
							
                           
                      
<div class="row" style="margin-top:30px;">
<div class="col-md-6">
<div class="form-group">
										<label>Şehir Merkezi:</label>
										<input type="text" class="form-control" id="us3-address">
									</div>
                                    <div class="row">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                          <label>Radius</label>
										<input type="text" class="form-control" id="us3-radius" value="<?php print $landmark['radius']; ?>" >
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                          <div class="form-group">
                                          <label>Lat</label>
										<input type="text" class="form-control" id="us3-lat" value="<?php print $landmark['lat']; ?>">
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Lon</label>
										<input type="text" class="form-control" id="us3-lon" value="<?php print $landmark['lng']; ?>">
                                        </div>
                                        </div>
									</div>
                                    <div class="form-group">
										<div id="us3" class="map-wrapper"></div>
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
                 
								</div>
							</div>

						
						</div>
					</div>
					<!-- /main charts -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
<script>

$(document).ready(function() {
	
	
	var cropperOptions = 
	{
		uploadUrl:'/landmark/upload',
		onAfterImgCrop:		function(){ picture_get() },
		cropUrl:'/landmark/crop?id=<?php  print $landmark['id']; ?>',
	}
	
	var cropperHeader = new Croppic('picture',cropperOptions);
	
	
	$('#description').summernote({
    lang: 'tr-TR'
  });
	$('#us3').locationpicker({
		<?php if(!empty($landmark['lat'])){ ?>
        location: {latitude: <?php print $landmark['lat']; ?>, longitude: <?php print $landmark['lng']; ?>}, 
		radius: <?php print $landmark['radius']; ?>,
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
	
	$.get( "/landmark/pictures?id=<?php  print $landmark['id']; ?>", function( data ) {
		$( "#picture_list" ).html( data );
	});	
	
	$.get( "/landmark/videos?id=<?php  print $landmark['id']; ?>", function( data ) {
		$( "#video_result" ).html( data );
	});	
	
});


function videoAdd()
{
	$( "#video_result" ).html('Yükleniyor...');
	$.get( "/landmark/videos?id=<?php  print $landmark['id']; ?>&video="+$('#video').val(), function( data ) {
		$( "#video_result" ).html( data );
	});	
}

function picture_get()
{
	$( "#picture_list" ).html('Yükleniyor...');
	$.get( "/landmark/pictures?id=<?php  print $landmark['id']; ?>", function( data ) {
		$( "#picture_list" ).html( data );
	});	
}

function picture_delete(picture)
{
	$( "#picture_list" ).html('Siliniyor...');
	$.get( "/landmark/pictures?id=<?php  print $landmark['id']; ?>&del="+picture, function( data ) {
		$( "#picture_list" ).html( data );
	});	
}

function video_delete(id)
{
	$( "#video_result" ).html('Siliniyor...');
	$.get( "/landmark/videos?id=<?php  print $landmark['id']; ?>&del="+id, function( data ) {
		$( "#video_result" ).html( data );
	});	
}



function picture_head(picture)
{
	$( "#picture_list" ).html('GÜncelleniyor...');
	$.get( "/landmark/pictures?id=<?php  print $landmark['id']; ?>&head="+picture, function( data ) {
		$( "#picture_list" ).html( data );
	});	
}


	function submitForm()
	{
		
		var description = $('#description').code();
		description = description.replace("/&nbsp;/gi", "");
		description = description.replace("’", "'");
		description = description.replace('“', '"');
		description = description.replace('”', '"');
		
		
	
		 
		var landmark    = $('#landmark').val();
		var type   		= $('#type').val();
		var url   		= $('#url').val();
		var lat         = $('#us3-lat').val();
		var lng         = $('#us3-lon').val();
		var radius      = $('#us3-radius').val();
		
		if(landmark == '' || type == '' || lat == '0' || lng == '0')
		{
			alert('GÜncelleme işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
		
		var formData    = "landmark="+landmark+"&type="+type+"&url="+url+"&lat="+lat+"&lng="+lng+"&radius="+radius+"&description="+description;
		$.ajax({
            type: 'POST',
            url: "/landmark/add?update=<?php  print $landmark['id']; ?>",
            data: formData,
            success: function (data){
				
				alert('Güncelleme işlemi başarıyla gerçekleşti.');
            }
        });
	}
</script>
</body>
</html>



           
                            
                            
						
			
<!-- /summernote click to edit -->


