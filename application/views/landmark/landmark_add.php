<?php $this->load->view('global/header'); ?>

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
							<h4><i class="icon-earth position-left"></i> Önemli Yer Ekle</h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('landmark'); ?>"><i class="icon-earth position-left"></i> Önemli Yerler</a></li>
							<li class="active">Önemli Yer Ekle</li>
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
                                
                                <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                          <label>Önemli Yer</label>
										<input type="text" class="form-control" id="landmark">
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                          <div class="form-group">
                                          <label>Tür</label>
										<select class="form-control" id="type" name="type">
                                        <option value="">Seçiniz</option>
                                         <option value="Restaurant">Restaurant</option>
                                         <option value="Havaalanı">Havaalanı</option>
                                         <option value="Eğlence">Eğlence</option>
                                         <option value="Müze / Ören Yeri">Müze / Ören Yeri</option>
                                         <option value="Gezilecek Yer">Gezilecek Yer</option>
                                         <option value="Tarihi Mekan">Tarihi Mekan</option>
                                         <option value="Üniversite">Üniversite</option>
                                         <option value="Fuar Alanı">Fuar Alanı</option>
                                         <option value="Sağlık">Sağlık</option>
                                        </select>
                                       
                                        </div>
                                        </div>   
									</div>

<label>Açıklama</label>
<div id="description"></div>
  
							
                           
                            
                            
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
										<input type="text" class="form-control" id="us3-radius">
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                          <div class="form-group">
                                          <label>Lat</label>
										<input type="text" class="form-control" id="us3-lat">
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Lon</label>
										<input type="text" class="form-control" id="us3-lon">
                                        </div>
                                        </div>
									</div>

</div>
<div class="col-md-6">
									

								
								   

									<div class="form-group">
										<div id="us3" class="map-wrapper"></div>
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
	$('#description').summernote({
    lang: 'tr-TR'
  });
	$('#us3').locationpicker({
        scrollwheel: false,
        inputBinding: {
			radiusInput: $('#us3-radius'),
            latitudeInput: $('#us3-lat'),
            longitudeInput: $('#us3-lon'),
            locationNameInput: $('#us3-address')        
        },
        enableAutocomplete: true
    });
	

	
});



	function submitForm()
	{
		
		var description = $('#description').code();
		var landmark    = $('#landmark').val();
		var type   		= $('#type').val();
		var lat         = $('#us3-lat').val();
		var lng         = $('#us3-lon').val();
		var radius      = $('#us3-radius').val();
		
		if(landmark == '' || type == '' || lat == '0' || lng == '0')
		{
			alert('Kayıt işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
		
		var formData    = "landmark="+landmark+"&type="+type+"&lat="+lat+"&lng="+lng+"&radius="+radius+"&description="+description;
		$.ajax({
            type: 'POST',
            url: "/landmark/add?add=1",
            data: formData,
            success: function (data){
				alert('BAŞARIYLA KAYDEDİLDİ!');
				window.location = "/landmark/landmark?id="+data;
            }
        });
	}
	

</script>
</body>
</html>



           
                            
                            
						
			
<!-- /summernote click to edit -->


