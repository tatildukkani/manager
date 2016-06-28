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
							<h4><i class="icon-file-text3 position-left"></i> Blog Ekle</h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('blog'); ?>"><i class="icon-file-text3 position-left"></i> Bloglar</a></li>
							<li class="active">Blog Ekle</li>
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
                                          <label>Başlık</label>
										<input type="text" class="form-control" id="title">
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                          <div class="form-group">
                                          <label>Kategori</label>
										<select class="form-control" id="categori_id" name="categori_id">
                                        <option value="">Seçiniz</option>
                                         <?php print $select; ?>
                                        </select>
                                       
                                        </div>
                                        </div>   
									</div>

<label>Açıklama</label>
<div id="description"></div>
  
							
                           
                            
                            
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
	
});



	function submitForm()
	{
		
		var description 		= $('#description').code();
		var title    			= $('#title').val();
		var category_id   		= $('#category_id').val();
		
		
		if(category_id == '' || title == '' || description == '')
		{
			alert('Kayıt işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
		
		var formData    = "title="+title+"&category_id="+category_id+"&description="+description;
		$.ajax({
            type: 'POST',
            url: "/blog/add?add=1",
            data: formData,
            success: function (data){
				alert('BAŞARIYLA KAYDEDİLDİ!');
				window.location = "/blog/blog?id="+data;
            }
        });
	}
	

</script>
</body>
</html>



           
                            
                            
						
			
<!-- /summernote click to edit -->


