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
							<h4><i class="icon-circle-code position-left"></i> Sayfa Ekle</h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
                            <li><a href="<?php print base_url('seo/pages'); ?>"><i class="icon-circle-code position-left"></i> Sayfalar</a></li>
							<li class="active">Sayfa Ekle</li>
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
                                          <label>URL</label>
										<input type="text" class="form-control" id="url">
                                        </div>
                                        </div>
                                        
                                
                                <div class="col-md-6">
                                  <div class="form-group">
                                          <label>Başlık</label>
										<input type="text" class="form-control" id="title">
                                        </div>
                                        </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                          <label>H1</label>
										<input type="text" class="form-control" id="h1">
                                        </div>
                                        </div>
                                        <div class="col-md-12">
                                  <div class="form-group">
                                          <label>Başlıkda alan adını dahil et</label>
                                          <select id="domain" class="form-control">
                                          <option value="Yes">Evet</option>
                                          <option value="No">Hayır</option>
                                          </select>
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                  <div class="form-group">
                                          <label>Açıklama</label>
										<input type="text" class="form-control" id="description">
                                        </div>
                                        </div>
                                        
                                         <div class="col-md-12">
                                  <div class="form-group">
                                          <label>Keywords</label>
										<input type="text" class="form-control" id="keywords">
                                        </div>
                                        </div>
                                        
                                            <div class="col-md-6">
                                  <div class="form-group">
                                          <label>Controller</label>
										<input type="text" class="form-control" id="controller" >
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                  <div class="form-group">
                                          <label>Controller Function</label>
										<input type="text" class="form-control" id="controller_function" >
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                  <div class="form-group">
                                          <label>Rel-Canonical</label>
										<input type="text" class="form-control" id="rel_canonical">
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                  <div class="form-group">
                                          <label>Rel-Prev</label>
										<input type="text" class="form-control" id="rel_prev">
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                  <div class="form-group">
                                          <label>Rel-Next</label>
										<input type="text" class="form-control" id="rel_next">
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
		var title   		= $('#title').val();
		var description   	= $('#description').val();
		var keywords   		= $('#keywords').val();
		var rel_canonical   = $('#rel_canonical').val();
		var rel_prev   		= $('#rel_prev').val();
		var rel_next   		= $('#rel_next').val();
		var controller   		= $('#controller').val();
		var controller_function = $('#controller_function').val();
		var h1       		= $('#h1').val();
		
		
		if(url == '')
		{
			alert('Kayıt işlemi yapılamadı. Lütfen tüm alanları kontrol ediniz.');
			return false;
		}
		
		var formData    = "title="+title+"&url="+url+"&description="+description+"&keywords="+keywords+"&rel_canonical="+rel_canonical+"&rel_prev="+rel_prev+"&rel_next="+rel_next+"&h1="+h1+"&domain="+domain+"&controller="+controller+"&controller_function="+controller_function;
		$.ajax({
            type: 'POST',
            url: "/seo/page_add?add=1",
            data: formData,
            success: function (data){
				alert('BAŞARIYLA KAYDEDİLDİ!');
				window.location = "/seo/page_detail?id="+data;
            }
        });
	}
	

</script>
</body>
</html>



           
                            
                            
						
			
<!-- /summernote click to edit -->


