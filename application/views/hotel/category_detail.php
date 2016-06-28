<?php $this->load->view('global/header'); ?>
<style>

#picture {
			width: 780px;
			height: 300px;
			background-color:#fbfbfb;
			position:relative; /* or fixed or absolute */
		}
		
.result{
	background-color:#fbfbfb;
	max-height:250px;
	min-height:250px;
	overflow:auto;
	padding:10px;
	margin-top:5px;
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
							<h4><i class="icon-bed2 position-left"></i><?php print $category['category']; ?></h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('hotel/category'); ?>"><i class="icon-bed2 position-left"></i> Otel Kategorileri</a></li>
							<li class="active"><?php print $category['category']; ?></li>
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
                                          <label>İsim</label>
										<input type="text" class="form-control" id="name" value="<?php print $category['category']; ?>">
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                               			   <div class="form-group">
                                          <label>Url</label>
										<input type="text" class="form-control" id="url" value="<?php print $category['url']; ?>">
                                        </div>
                                        </div>
                                        
                                         
                                        <div class="col-md-6">
                                        <div class="form-group">
                                        <label>Ana Kategori</label> 
										<select id="parent_id" class="form-control" name="parent_id">		
                                        <option value="">Ana kategorisi yok!</option>
                                        <?php for($i=0; $i<count($categories); $i++){ 
										if($categories[$i]['id'] != $category['id']){
										?>
                                        <option <?php if($categories[$i]['id'] == $category['parent_id']){ ?>selected<?php } ?> value="<?php print $categories[$i]['id']; ?>"><?php print $categories[$i]['category']; ?></option>
                                        <?php }} ?>
                                        </select>
                                        </div>
                                        
                                        </div>
                                        
                                        <div class="col-md-6">
                                 		 <div class="form-group">
                                          <label>Kontrol Fonksiyonu</label>
										<input type="text" class="form-control" id="controller_function" value="<?php print $category['controller_function']; ?>">
                                        </div>
                                        </div>
                                       
                                       </div> 
                                        
                                       <div class="row">
                                       <?php 
									   $eb_key = '';
									   $nochild_key = '';
									   $min_price_key = '';
									   $min_point_key = '';
									   $max_point_key = '';
									   $max_price_key = '';
									   $age1_key = '';
									   $age2_key = '';
									   $min_review_key = '';
									   $max_review_key = '';
									   
									    ?>
                                       
                                        <div class="col-md-6"  style="background-color:#fbfbfb; margin-top:20px; padding-bottom:30px;">
                                        <h3>Listeleme Özellikleri</h3>
                                        <div class="row">      
                                        <div class="col-md-6" >
                                		  <div class="form-group">
                                          <?php if(!empty($vars[0])){ $eb_key = array_search('eb', array_column($vars, 'category_var')); } ?>
                                          	<input  type="checkbox" name="eb" <?php if(is_numeric($eb_key)){ ?>checked<?php } ?> id="eb">
											<label for="eb">Erken Rezervasyon</label>
                                       	  </div>
                                        </div>
                                        <div class="col-md-6">
                                		  <div class="form-group">
                                           <?php if(!empty($vars[0])){ $nochild_key = array_search('nochild', array_column($vars, 'category_var'));} ?>
											<input  type="checkbox" name="nochild" <?php if(is_numeric($nochild_key)){ ?>checked<?php } ?> id="nochild">
											<label for="nochild">Çocuk Kabul Etmez</label>
                                       	  </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-3"> 
                                		  <div class="form-group">
                                          <?php if(!empty($vars[0])){ $min_price_key = array_search('min_price', array_column($vars, 'category_var'));}  ?>
                                          <label for="min_price">Min. Fiyat</label>
										  <input type="text"  class="form-control" <?php if(is_numeric($min_price_key)){ ?>value="<?php print $vars[$min_price_key]['category_val']; ?>"<?php } ?> style="width:80px;   margin-right:5px;" id="min_price" name="min_price">
                                       	  </div>
                                        </div>
                                        
                                         
                                        
                                        <div class="col-md-3">
                                		  <div class="form-group">
                                            <?php if(!empty($vars[0])){ $max_price_key = array_search('max_price', array_column($vars, 'category_var')); } ?>
                                          <label for="max_price">Max. Fiyat</label>
									     <input type="text"  class="form-control" <?php if(is_numeric($max_price_key)){ ?>value="<?php print $vars[$max_price_key]['category_val']; ?>"<?php } ?> style="width:80px; margin-right:5px;" id="max_price" name="max_price">
                                       	  </div>
                                        </div>
                                        
                                         <div class="col-md-3">
                                		  <div class="form-group">
                                           <?php if(!empty($vars[0])){ $age1_key = array_search('age1', array_column($vars, 'category_var')); } ?>
                                          <label for="age1">Min. 1. Çocuk</label>
										  <input type="text"  class="form-control" <?php if(is_numeric($age1_key)){ ?>value="<?php print $vars[$age1_key]['category_val']; ?>"<?php } ?> style="width:80px;  margin-right:5px;" id="age1" name="age1">
                                       	  </div>
                                        </div>
                                        
                                         
                                        
                                        <div class="col-md-3">
                                		  <div class="form-group">
                                           <?php if(!empty($vars[0])){ $age2_key = array_search('age2', array_column($vars, 'category_var')); } ?>
                                          <label for="age1">Min. 2. Çocuk</label>
										  <input type="text"  class="form-control" <?php if(is_numeric($age2_key)){ ?>value="<?php print $vars[$age1_key]['category_val']; ?>"<?php } ?> style="width:80px;  margin-right:5px;" id="age2" name="age2">
                                       	  </div>
                                        </div>
                                        
                                        
                                       
                                         <div class="col-md-3">
                                		  <div class="form-group">
                                           <?php if(!empty($vars[0])){ $min_point_key = array_search('min_point', array_column($vars, 'category_var')); } ?>
                                          <label for="min_point">Min. Puan</label>
										  <input type="text" class="form-control"  <?php if(is_numeric($min_point_key)){ ?>value="<?php print $vars[$min_point_key]['category_val']; ?>"<?php } ?> style="width:80px;  margin-right:5px;" id="min_point" name="min_point">
                                       	  </div>
                                        </div>
                                        
                                         
                                        
                                        <div class="col-md-3">
                                		  <div class="form-group">
                                           <?php if(!empty($vars[0])){ $max_point_key = array_search('max_point', array_column($vars, 'category_var')); } ?>
                                          <label for="max_point">Max. Puan</label>
									     <input type="text"  class="form-control" <?php if(is_numeric($max_point_key)){ ?>value="<?php print $vars[$max_point_key]['category_val']; ?>"<?php } ?> style="width:80px; margin-right:5px;" id="max_point" name="max_point">
                                       	  </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                		  <div class="form-group">
                                          <?php if(!empty($vars[0])){ $min_review_key = array_search('min_review', array_column($vars, 'category_var')); } ?>
                                          <label for="min_review">Min. Yorum</label>
										  <input type="text"  class="form-control" <?php if(is_numeric($min_review_key)){ ?>value="<?php print $vars[$min_review_key]['category_val']; ?>"<?php } ?> style="width:80px;  margin-right:5px;" id="min_review" name="min_review">
                                       	  </div>
                                        </div>
                                        
                                         
                                        
                                        <div class="col-md-3">
                                		  <div class="form-group">
                                          <?php if(!empty($vars[0])){ $max_review_key = array_search('max_review', array_column($vars, 'category_var')); } ?>
                                          <label for="max_review">Max. Yorum</label>
									     <input type="text"  class="form-control" <?php if(is_numeric($max_review_key)){ ?>value="<?php print $vars[$max_review_key]['category_val']; ?>"<?php } ?> style="width:80px; margin-right:5px;" id="max_review" name="max_review">
                                       	  </div>
                                        </div>
                                        
                                        <div class="col-md-12 ">
                                       <button type="button" class="btn bg-teal-400" onClick="listingForm();">Listeleme Özelliklerini Kaydet</button> 
                                       </div>
                                        
                                        
                                        
                                        
                                        </div>
                                        </div> 
                                        
                                    	 <div class="col-md-6">
                                        <label>Açıklama</label>
<div id="description"><?php print $category['description']; ?></div>
										</div>
                                     
                                       
                                       </div> 
                                        
                                         
                                       <div class="row">
                                        <div class="col-md-3" style="background-color:#fbfbfb; margin-top:20px; padding-bottom:30px; min-height:387px;">
                                         <h3>Otel Özellikleri</h3>
                                         <form action="">
								
										<fieldset>
											<div class="form-group">
                                            <label>Anahtar:</label>
												<input type="text" class="form-control" name="l_key" id="l_key" placeholder="Anahtar">
											</div>
                                            <div class="form-group">
                                            <label>Değer</label>
												<input type="text" class="form-control" name="l_value" id="l_value" placeholder="Değer">
											</div>
                                             <div class="form-group">
                                            <label>Açıklama</label>
												<input type="text" class="form-control" name="l_description" id="l_description" placeholder="Açıklama">
											</div>
										</fieldset>

										<div class="text-right">
											<button type="submit"   onClick="listingkeyForm();" class="btn btn-primary btn bg-teal-400">Otel Özelliği Ekle</button>
										</div>
								
                                        </form> 
                                        </div>
                                                                              
                                        <div class="col-md-3">
                                        <h3>Bölgeler</h3>
                                        <form action="/hotel/destination_find" id="destinationForm">
								
										<fieldset>
											<div class="form-group">
												<input type="text" class="form-control" name="d_q" id="d_q" placeholder="Bölge Ara">
											</div>
										</fieldset>

										<div class="text-right">
											<button type="submit" id="destination_search" class="btn btn-primary">Ara <i class=" icon-search4 position-right"></i></button>
										</div>
								
                                        </form>
                                        <div id="destination_result" class="result">Henüz arama yapmadınız...</div>
                                            
                                        
                                        </div>
                                        
                                        <div class="col-md-3">
                                        <h3>Oteller</h3>
                                         <form action="/hotel/hotel_find" id="hotelForm">
								
										<fieldset>
											<div class="form-group">
												<input type="text" class="form-control" name="h_q" id="h_q" placeholder="Otel Ara">
											</div>
										</fieldset>

										<div class="text-right">
											<button type="submit" id="category_search" class="btn btn-primary">Ara <i class=" icon-search4 position-right"></i></button>
										</div>
								
                                        </form>
                                        <div id="hotel_result" class="result">Henüz arama yapmadınız...</div>
                                           
                                        
                                        </div>
                                       
                                       
                                         <div class="col-md-3">
                                        <h3>Konsept</h3>
                                         <form action="/hotel/concept_find" id="conceptForm">
								
										<fieldset>
											<div class="form-group">
												<input type="text" class="form-control" name="c_q" id="c_q" placeholder="Konsept Ara">
											</div>
										</fieldset>

										<div class="text-right">
											<button type="submit" id="category_search" class="btn btn-primary">Ara <i class=" icon-search4 position-right"></i></button>
										</div>
								
                                        </form>
                                        <div id="concept_result" class="result">Henüz arama yapmadınız...</div>
                                           
                                        
                                        </div>
                                       
                                       
                                       
                                        
									</div>


  <div class="row">
  
  	<div class="col-md-3" style="margin-top:20px;">
    <h3>Kategori İçeriği</h3>
                                        <div id="category_area"></div>
    </div>
    <div class="col-md-9">
    <div id="hotel_list" style="margin-top:20px;"></div>
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
	
	
	$('#description').summernote({
    lang: 'tr-TR'
  }); 
	
	$( "#category_area" ).html( 'Yükleniyor...' );
	$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>", function( data ) {
		$( "#category_area" ).html( data );
	});
	
	$( "#hotel_list" ).html( 'Yükleniyor...' );
	$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
		$( "#hotel_list" ).html( data );
	});
	
	 var frm = $('#destinationForm');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: '/hotel/destination_find?id=<?php print $category['id']; ?>',
            data: frm.serialize(),
            success: function (data) {
				$('#destination_result').html(data);
			
            }
        });

        ev.preventDefault();
    });
	
	 var frm2 = $('#hotelForm');
   		 frm2.submit(function (ev) {
        $.ajax({
            type: frm2.attr('method'),
            url: '/hotel/hotel_find?id=<?php print $category['id']; ?>',
            data: frm2.serialize(),
            success: function (data) {
				$('#hotel_result').html(data);
			
            }
        });

        ev.preventDefault();
    });
	
	
	var frm3 = $('#conceptForm');
   		 frm3.submit(function (ev) {
        $.ajax({
            type: frm3.attr('method'),
            url: '/hotel/concept_find?id=<?php print $category['id']; ?>',
            data: frm3.serialize(),
            success: function (data) {
				$('#concept_result').html(data);
			
            }
        });

        ev.preventDefault();
    });
	
	
	

	
	

	
});




function destination_add(id,type,name)
{
	$( "#category_area" ).html( 'Yükleniyor...' );
	$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>&destination_add=1&did="+id+"&name="+name+"&type="+type, function( data ){
		$( "#hotel_list" ).html( 'Yükleniyor...' );
		$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
			$( "#hotel_list" ).html( data );
		});
		$( "#category_area" ).html( data );
	});	
}

function destination_del(id)
{
	$( "#category_area" ).html( 'Yükleniyor...' );
	$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>&destination_del="+id, function( data ) {
		$( "#hotel_list" ).html( 'Yükleniyor...' );
		$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
			$( "#hotel_list" ).html( data );
		});
		$( "#category_area" ).html( data );
	});	
}

function hotel_add(id,name,desc)
{
	$( "#category_area" ).html( 'Yükleniyor...' );
	$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>&hotel_add=1&hid="+id+"&name="+name+"&desc="+desc, function( data ) {
		$( "#hotel_list" ).html( 'Yükleniyor...' );
		$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
			$( "#hotel_list" ).html( data );
		});
		$( "#category_area" ).html( data );
	});	
}

function hotel_del(id)
{
	$( "#category_area" ).html( 'Yükleniyor...' );
	$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>&hotel_del="+id, function( data ) {
		$( "#hotel_list" ).html( 'Yükleniyor...' );
		$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
			$( "#hotel_list" ).html( data );
		});
		$( "#category_area" ).html( data );
	});	
}


function concept_add(id,name,desc)
{
	$( "#category_area" ).html( 'Yükleniyor...' );
	$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>&concept_add=1&cid="+id+"&name="+name, function( data ) {
		
		$( "#hotel_list" ).html( 'Yükleniyor...' );
		$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
			$( "#hotel_list" ).html( data );
		});
		$( "#category_area" ).html( data );
	});	
}

function concept_del(id)
{
	$( "#category_area" ).html( 'Yükleniyor...' );
	$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>&concept_del="+id, function( data ) {
		$( "#hotel_list" ).html( 'Yükleniyor...' );
		$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
			$( "#hotel_list" ).html( data );
		});
		$( "#category_area" ).html( data );
	});	
}

function var_del(id,vars)
{
	$("#"+vars).val('');
	$( "#category_area" ).html( 'Yükleniyor...' );
	$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>&var_del="+id, function( data ) {
		$( "#hotel_list" ).html( 'Yükleniyor...' );
		$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
			$( "#hotel_list" ).html( data );
		});
		$( "#category_area" ).html( data );
	});	
}



	function listingForm()
	{
		
		var eb             = '';
		var nochild   	   = '';
		var min_price      = $('#min_price').val();
		var max_price      = $('#max_price').val();
		var min_review     = $('#min_review').val();
		var max_review     = $('#max_review').val();
		var min_point      = $('#min_point').val();
		var max_point      = $('#max_point').val();
		var age1     	   = $('#age1').val();
		var age2           = $('#age2').val();
		
		if($("#eb").is(':checked')){
   			 eb= '1';  
		}
		if($("#nochild").is(':checked')){
   			 nochild= '1';  
		}
		
		
		var formData    = "eb="+eb+"&nochild="+nochild+"&min_price="+min_price+"&max_price="+max_price+"&min_review="+min_review+"&max_review="+max_review+"&min_point="+min_point+"&max_point="+max_point+"&age1="+age1+"&age2="+age2;
		$.ajax({
            type: 'POST',
            url: "/hotel/category_add?listing_update=<?php  print $category['id']; ?>",
            data: formData,
            success: function (data){
				$( "#category_area" ).html( 'Yükleniyor...' );
				$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>", function( data ) {
					$( "#category_area" ).html( data );
				}); 
				$( "#hotel_list" ).html( 'Yükleniyor...' );
				$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
					$( "#hotel_list" ).html( data );
				});
				alert('Güncelleme işlemi başarıyla gerçekleşti.');
            }
        });
	}
	
	
	function listingkeyForm()
	{
		
		var l_key              = $('#l_key').val();
		var l_value   	       = $('#l_value').val();
		var l_description      = $('#l_description').val();
		
		if(l_key == '' || l_value == '' || l_description == '' )
		{
			alert('Ekleme işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
				
		var formData    = "l_key="+l_key+"&l_value="+l_value+"&l_description="+l_description;
		$.ajax({
            type: 'POST',
            url: "/hotel/category_add?listing_key_add=<?php  print $category['id']; ?>",
            data: formData,
            success: function (data){
				$( "#category_area" ).html( 'Yükleniyor...' );
				$.get( "/hotel/category_area?id=<?php  print $category['id']; ?>", function( data ) {
					$( "#category_area" ).html( data );
				}); 
				$( "#hotel_list" ).html( 'Yükleniyor...' );
		$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
			$( "#hotel_list" ).html( data );
		});
				$('#l_key').val('');
				$('#l_value').val('');
				$('#l_description').val('');
				alert('Ekleme işlemi başarıyla gerçekleşti.');
            }
        });
	}


	function submitForm()
	{
		
		var url        			  = $('#url').val();
		var name   				  = $('#name').val();
		var description   	   	  = $('#description').val();
		var parent_id   		  = $('#parent_id').val();
		var controller_function   = $('#controller_function').val();
		var description           = $('#description').code();
	
		
		if(name == '' || url == ''  )
		{
			alert('Güncelleme işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
		
		var formData    = "url="+url+"&name="+name+"&description="+description+"&controller_function="+controller_function+"&parent_id="+parent_id;
		$.ajax({
            type: 'POST',
            url: "/hotel/category_add?update=<?php  print $category['id']; ?>",
            data: formData,
            success: function (data){
				$( "#hotel_list" ).html( 'Yükleniyor...' );
		$.get( "/hotel/category_hotels?id=<?php  print $category['id']; ?>", function( data ) {
			$( "#hotel_list" ).html( data );
		});
				alert('Güncelleme işlemi başarıyla gerçekleşti.');
            }
        });
	}
</script>
</body>
</html>



           
                            
                            
						
			
<!-- /summernote click to edit -->


