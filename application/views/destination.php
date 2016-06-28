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
							<h4><i class="icon-location4 position-left"></i> Bölgeler</h4>
                          
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
							<li class="active">Bölgeler</li>
						</ul>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

					<!-- Main charts -->
					<div class="row">
						<div class="col-md-3" id="dest_menu">
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Bölge Bul</h6>
                                      <a href="javascript:void(0)" style="display:none" class="pull-right" onClick="gizle();" id="gizle_btn"><span class="icon-eye"></span> Gizle</a>
								</div>
								
								<div class="panel-body">
							<form action="/destination/find" id="destinationForm">
								
										<fieldset>
											<div class="form-group">
												<input type="text" class="form-control" name="q" id="q" placeholder="Bölge Ara">
											</div>
										</fieldset>

										<div class="text-right">
											<button type="submit" id="destination_search" class="btn btn-primary">Ara <i class=" icon-search4 position-right"></i></button>
										</div>
								
							</form>
                            <div id="destination_result" style="margin-top:15px;"></div>
								</div>
							</div>

							
						</div>

						<div class="col-md-9" id="dest_detail">
							<div class="panel panel-flat">
							
								
								<div class="panel-body">
									<div id="destination_detail">İçeriğin yüklenmesi için bölge seçmelisiniz.</div>
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
	<!-- /page container -->
<script type="text/javascript">
    var frm = $('#destinationForm');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: '/destination/find',
            data: frm.serialize(),
            success: function (data) {
				$('#destination_result').html(data);
			
            }
        });

        ev.preventDefault();
    });
	
	

	
	function dest(id,name)
	{
		
		
		$.get( "destination/detail?id="+id+"&name="+name, function( data ) {
		  $( "#destination_detail" ).html( data );
		  gizle();
		});	
		
	}
	
	
	function gizle()
	{
		$('#dest_menu').hide();
		$("#dest_detail" ).removeClass( "col-md-9" ).addClass( "col-md-12" );
		$('#goster_btn').show();
		$('#gizle_btn').hide();
	}
	
	function goster()
	{
		
		$("#dest_detail" ).removeClass( "col-md-12" ).addClass( "col-md-9" );
		$('#dest_menu').show();
		$('#goster_btn').hide();
		$('#gizle_btn').show();
	}
	
</script>
</body>
</html>
