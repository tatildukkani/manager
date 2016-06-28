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
							<h4><i class="icon-earth position-left"></i> Kategori Bannerı Ekle</h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('banner/category_banner'); ?>"><i class="icon-earth position-left"></i> Kategori Bannerları</a></li>
							<li class="active">Kategori Bannerı Ekle</li>
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
										<input type="text" class="form-control" id="name">
                                        </div>
                                        </div>
                                        
                                 <div class="col-md-6">
                                  <div class="form-group">
                                          <label>Link</label>
										<input type="text" class="form-control" id="link">
                                        </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="col-md-12">
                                 		 <div class="form-group">
                                          <label>Tarih Aralığı</label>
										<input type="text" class="form-control daterange-basic" value="" id="banner_date">
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

  $('.daterange-basic').daterangepicker({
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-default',
		locale: {
            format: 'DD.MM.YYYY'
        }
    });
});
	function submitForm()
	{
		
		var name   				 = $('#name').val();
		var banner_link   		= $('#link').val();
		var banner_date         = $('#banner_date').val();
		
		if(name == '' || banner_link == '')
		{
			alert('Kayıt işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
		
		var formData    = "name="+name+"&link="+banner_link+"&banner_date="+banner_date;
		$.ajax({
            type: 'POST',
            url: "/banner/category_banner_add?add=1",
            data: formData,
            success: function (data){
				alert('BAŞARIYLA KAYDEDİLDİ!');
				window.location = "/banner/category_banner?id="+data;
            }
        });
	}
	

</script>
</body>
</html>



           
                            
                            
						
			
<!-- /summernote click to edit -->


