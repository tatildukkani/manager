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
							<h4><i class="icon-file-text3 position-left"></i> Blog Kategorisi - <?php print $category['category']; ?></h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('blog/category'); ?>"><i class="icon-file-text3 position-left"></i> Blog Kategorileri</a></li>
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
                                <div class="col-md-12">
                                  <div class="form-group">
                                          <label>Kategori</label>
										<input type="text" class="form-control" id="category" value="<?php print $category['category']; ?>">
                                        </div>
                                        </div>
                                        
                                      <div class="col-md-12">
                                         <div class="form-group">
                                          <label>Ana Kategorisi</label>
										<select class="form-control" id="parent_id" name="parent_id">
                                        <option value="">Bu Ana Kategori</option>
                                         <?php print $select; ?>
                                        </select>
                                       
                                        </div>
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
            url: "/blog/category_add?update=<?php  print $category['id']; ?>",
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


