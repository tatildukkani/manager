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
							<h4><i class="icon-file-text3 position-left"></i> Oteller</h4>
                          
						</div>
                        <div class="heading-elements">
							<div class="heading-btn-group">
								<a href="<?php print base_url('hotel/add'); ?>" class="btn btn-link btn-float has-text"><i class="icon-add text-primary"></i><span>Yeni Ekle</span></a>
								
							</div>
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
							<li class="active">Oteller</li>
						</ul>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

					<!-- Main charts -->
					<div class="row">
						<div class="col-md-12" >
						
                        <?php if(!empty($noty)){ ?>
					<?php if($noty == '1'){ ?>
                    	<div class="alert alert-success" role="alert">İşleminiz başrıyla tamamlanmıştır.</div>
                    <?php } ?>
				<?php } ?>
                        
                        <div class="panel panel-flat">
						

						<div class="panel-body">
							
						

						<table id="blogs" class="table datatable-ajax">
							<thead>
								<tr>
					                <th>ID</th>
                                    <th>Hotel ID</th>
					                <th>Resim</th>
                                    <th>Başlık</th>
					                
                                    <th>İşlem</th>
					            </tr>
							</thead>
						</table>
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
<script language="javascript">

 $(document).ready(function() {
	
		
		  $("#blogs").dataTable({
                responsive: false,
				"columnDefs": [
					{
						"render": function ( data, type, row ) 
						{
							return '<a href="/hotel/hotel_detail?id='+row[0]+'" class="label label-primary"><span class="icon-pencil4"></span> Güncelle</a> <a href="/hotel/hotel_list?del='+row[0]+'" style="margin-left:10px;" class="label label-danger"><span class="icon-trash"></span> Sil</a>';
						},
						"targets": 4
					}
					
				],
                aLengthMenu: [
                    [10, 25, 50, 100,500],
                    [10, 25, 50, 100,500]
                ],
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "/hotel/datasource"
            });	 
	 
 });

</script>
</body>
</html>
