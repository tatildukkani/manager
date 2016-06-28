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
							<h4><i class="icon-file-text3 position-left"></i> Blog - <?php print $post['title']; ?></h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('blog'); ?>"><i class="icon-file-text3 position-left"></i> Blog</a></li>
							<li class="active"><?php print $post['title']; ?></li>
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
                                <div class="col-md-6">
                                  <div class="form-group">
                                          <label>Başlık</label>
										<input type="text" class="form-control" id="title" value="<?php print $post['title']; ?>">
                                        </div>
                                        </div>
                                        
                                      <div class="col-md-6">
                                         <div class="form-group">
                                          <label>Kategori</label>
										<select class="form-control" id="category_id" name="category_id">
                                        <option value="">Seçiniz</option>
                                         <?php print $select; ?>
                                        </select>
                                       
                                        </div>
                                        </div>   
									</div>

						
                            		  <label>Açıklama</label>
										<div id="description"><?php print $post['post']; ?></div>
                      
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
	
	
	var cropperOptions = 
	{
		uploadUrl:'/blog/upload',
		onAfterImgCrop:		function(){ picture_get() },
		cropUrl:'/blog/crop?id=<?php  print $post['id']; ?>',
	}
	
	var cropperHeader = new Croppic('picture',cropperOptions);
	
	
	$('#description').summernote({
    lang: 'tr-TR'
  });
	
	
	$.get( "/blog/pictures?id=<?php  print $post['id']; ?>", function( data ) {
		$( "#picture_list" ).html( data );
	});	
	

	
});

function picture_get()
{
	$( "#picture_list" ).html('Yükleniyor...');
	$.get( "/blog/pictures?id=<?php  print $post['id']; ?>", function( data ) {
		$( "#picture_list" ).html( data );
	});	
}
function picture_delete(picture)
{
	$( "#picture_list" ).html('Siliniyor...');
	$.get( "/blog/pictures?id=<?php  print $post['id']; ?>&del="+picture, function( data ) {
		$( "#picture_list" ).html( data );
	});	
}

function picture_head(picture)
{
	$( "#picture_list" ).html('GÜncelleniyor...');
	$.get( "/blog/pictures?id=<?php  print $post['id']; ?>&head="+picture, function( data ) {
		$( "#picture_list" ).html( data );
	});	
}

	function submitForm()
	{
		
		
		var category   		= $('#category').val();
		var parent_id   		= $('#parent_id').val();
		
		
		if(category == '')
		{
			alert('GÜncelleme işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
		
		var formData    = "category="+category+"&parent_id="+parent_id;
		$.ajax({
            type: 'POST',
            url: "/blog/category_add?update=<?php  print $post['id']; ?>",
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


