<?php $this->load->view('global/header'); ?>
<style>

#picture {
			width: 780px;
			height: 300px;
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
							<h4><i class="icon-earth position-left"></i> Kategori Bannerı - <?php print $banner['name']; ?></h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('banner/category'); ?>"><i class="icon-earth position-left"></i> Kategori Bannerları</a></li>
							<li class="active"><?php print $banner['name']; ?></li>
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

</div>
</div>                          
     						 <div class="row" style="margin-bottom:30px;">
                                <div class="col-md-6" id="resim">
                                <?php if(empty($banner['picture'])){ print '<strong>Henüz banner yüklenmemiş.</strong>'; } else { ?><h3>Banner:</h3> <img src="http://manage.tatildukkani.com/assets/data/banners/<?php print $banner['picture']; ?>"> <?php } ?>
                                </div>
                                
                             </div>
                                
                                
                                <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                          <label>İsim</label>
										<input type="text" class="form-control" id="name" value="<?php print $banner['name']; ?>">
                                        </div>
                                        </div>
                                        
                                        
                                        
                                        
                                         <div class="col-md-6">
                                  <div class="form-group">
                                          <label>Link</label>
										<input type="text" class="form-control" id="url" value="<?php print $banner['link']; ?>">
                                        </div>
                                        </div>
                                        
                                         <div class="col-md-12">
                                 		 <div class="form-group">
                                          <label>Tarih Aralığı</label>
										<input type="text" class="form-control daterange-basic" <?php if(!empty($banner['begin'])){ ?> value="<?php print date_convert($banner['begin']).' - '.date_convert($banner['end']); ?>"<?php } ?> id="banner_date">
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                          <div class="form-group">
                                          <label>Popülerlik</label>
										<input type="text" class="form-control" value="<?php print $banner['popularity']; ?>" id="popularity">
                                       
                                        </div>
                                        </div>   
                                        
                                        <div class="col-md-6">
                                          <div class="form-group">
                                          <label>Durum</label>
										<select class="form-control" id="status" name="status">
                                         <option <?php if($banner['status'] == 'Active'){ ?>selected<?php } ?> value="Active">Aktif</option>
                                         <option <?php if($banner['status'] == 'Passive'){ ?>selected<?php } ?> value="Passive">Pasif</option>
                                       
                                        </select>
                                       
                                        </div>
                                        </div>   
                                        
                                        <div class="col-md-4">
                                        <h3>Bölgeler</h3>
                                        <form action="/banner/destination_find" id="destinationForm">
								
										<fieldset>
											<div class="form-group">
												<input type="text" class="form-control" name="d_q" id="d_q" placeholder="Bölge Ara">
											</div>
										</fieldset>

										<div class="text-right">
											<button type="submit" id="destination_search" class="btn btn-primary">Ara <i class=" icon-search4 position-right"></i></button>
										</div>
								
                                        </form>
                                        <div id="destination_result" style="margin-top:15px;"></div>
                                            
                                        
                                        </div>
                                        
                                        <div class="col-md-4">
                                        <h3>Kategoriler</h3>
                                         <form action="/banner/category_find" id="categoryForm">
								
										<fieldset>
											<div class="form-group">
												<input type="text" class="form-control" name="c_q" id="c_q" placeholder="Bölge Ara">
											</div>
										</fieldset>

										<div class="text-right">
											<button type="submit" id="category_search" class="btn btn-primary">Ara <i class=" icon-search4 position-right"></i></button>
										</div>
								
                                        </form>
                                        <div id="category_result" style="margin-top:15px;"></div>
                                           
                                        
                                        </div>
                                       
                                        <div class="col-md-4">
                                        <h3>Eklenen Alanlar</h3>
                                        <div id="areas"></div>
                                        </div>
                                        
									</div>


  
							
                           
                      
<div class="row" style="margin-top:30px;">
		

									
   
   
 
   
   
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
	
	$( "#areas" ).html( 'Yükleniyor...' );
	$.get( "/banner/category_banner_areas?id=<?php  print $banner['id']; ?>", function( data ) {
		$( "#areas" ).html( data );
	});	
	
	 var frm = $('#destinationForm');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: '/banner/destination_find?id=<?php print $banner['id']; ?>',
            data: frm.serialize(),
            success: function (data) {
				$('#destination_result').html(data);
			
            }
        });

        ev.preventDefault();
    });
	
	 var frm2 = $('#categoryForm');
    frm2.submit(function (ev) {
        $.ajax({
            type: frm2.attr('method'),
            url: '/banner/category_find?id=<?php print $banner['id']; ?>',
            data: frm2.serialize(),
            success: function (data) {
				$('#category_result').html(data);
			
            }
        });

        ev.preventDefault();
    });
	
	 $('.daterange-basic').daterangepicker({
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-default',
		locale: {
            format: 'DD.MM.YYYY'
        }
    });
	
	
	var cropperOptions = 
	{
		uploadUrl:'/banner/upload?id=<?php print $banner['id']; ?>',
		onAfterImgCrop: function(){ $('#resim').html('<h3>Banner:</h3> <img src="http://manage.tatildukkani.com/assets/data/banners/category_banner_<?php print $banner['id']; ?>.jpeg">');},
		cropUrl:'/banner/crop?id=<?php print $banner['id']; ?>',
	}
	
	var cropperHeader = new Croppic('picture',cropperOptions);
	

	
});






function area_add(area,name)
{
	$( "#areas" ).html( 'Yükleniyor...' );
	$.get( "/banner/category_banner_areas?id=<?php  print $banner['id']; ?>&add=1&area="+area+"&name="+name, function( data ) {
		$( "#areas" ).html( data );
	});	
}

function area_del(id)
{
	$( "#areas" ).html( 'Yükleniyor...' );
	$.get( "/banner/category_banner_areas?id=<?php  print $banner['id']; ?>&del="+id, function( data ) {
		$( "#areas" ).html( data );
	});	
}





	function submitForm()
	{
		
		var url         = $('#url').val();
		var name   		= $('#name').val();
		var status   	= $('#status').val();
		var popularity    = $('#popularity').val();
		var banner_date   = $('#banner_date').val();
	
		
		if(name == '' || url == '' || status == '' )
		{
			alert('GÜncelleme işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
		
		var formData    = "url="+url+"&name="+name+"&status="+status+"&popularity="+popularity+"&banner_date="+banner_date;
		$.ajax({
            type: 'POST',
            url: "/banner/category_banner_add?update=<?php  print $banner['id']; ?>",
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


