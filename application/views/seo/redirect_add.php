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
							<h4><i class="icon-circle-code position-left"></i> 302 Yönlendirme Ekle</h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('seo/redirects'); ?>"><i class="icon-circle-code position-left"></i> 302 Yönlendirmeler</a></li>
							<li class="active">302 Yönlendirme Ekle</li>
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
                                          <label>Kaynak</label>
										<input type="text" class="form-control" id="url">
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                  <div class="form-group">
                                          <label>Hedef</label>
										<input type="text" class="form-control" id="redirect">
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
		
		var url    			= $('#url').val();
		var redirect   		= $('#redirect').val();
		
		
		if(url == '' || redirect == '' )
		{
			alert('Kayıt işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
		
		var formData    = "redirect="+redirect+"&url="+url;
		$.ajax({
            type: 'POST',
            url: "/seo/redirect_add?add=1",
            data: formData,
            success: function (data){
				alert('BAŞARIYLA KAYDEDİLDİ!');
				window.location = "/seo/redirect_detail?id="+data;
            }
        });
	}
	

</script>
</body>
</html>



           
                            
                            
						
			
<!-- /summernote click to edit -->


