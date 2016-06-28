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
							<h4><i class="icon-file-text3 position-left"></i> Blog Kategorileri</h4>
                          
						</div>
                        <div class="heading-elements">
							<div class="heading-btn-group">
								<a href="<?php print base_url('blog/category_add'); ?>" class="btn btn-link btn-float has-text"><i class="icon-add text-primary"></i><span>Yeni Kategori Ekle</span></a>
								
							</div>
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Dashboard</a></li>
							<li class="active">Blog Kategorileri</li>
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
                        
                        
                        
                        
					<!-- Table tree -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h6 class="panel-title">Kategoriler</h6>
							
						</div>

						
						
						<div class="table-responsive">
							<table class="table table-bordered tree-table">
								<thead>
									<tr>
                                    	<th style="width: 80px;">ID</th>
										<th style="width: 80px;">#</th>
										<th>Kategori</th>
										<th style="width: 246px;">İşlem</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!-- /table tree -->
              
                        

							
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
	
		$(".tree-table").fancytree({
        extensions: ["table"],
        checkbox: false,
        table: {
            indentation: 20,      // indent 20px per node level
            nodeColumnIdx: 2,     // render the node title into the 2nd column
            checkboxColumnIdx: 0  // render the checkboxes into the 1st column
        },
        source: {
            url: "<?php print base_url('/blog/category_json'); ?>"
        },
        renderColumns: function(event, data) {
            var node = data.node,
            $tdList = $(node.tr).find(">td");

            // (index #0 is rendered by fancytree by adding the checkbox)
            $tdList.eq(1).text(node.getIndexHier()).addClass("alignRight");

            // (index #2 is rendered by fancytree)
            $tdList.eq(0).text(node.key);
            $tdList.eq(3).html('<a href="/blog/category_detail?id='+node.key+'" class="label label-primary"><span class="icon-pencil4"></span> Güncelle</a> <a href="/blog/category?del='+node.key+'" style="margin-left:10px;" class="label label-danger"><span class="icon-trash"></span> Sil</a>');

            // Style checkboxes
            $(".styled").uniform({radioClass: 'choice'});
        }
    });

    // Handle custom checkbox clicks
    $(".tree-table").delegate("input[name=like]", "click", function (e){
        var node = $.ui.fancytree.getNode(e),
        $input = $(e.target);
        e.stopPropagation(); // prevent fancytree activate for this row
        if($input.is(":checked")){
            alert("like " + $input.val());
        }
        else{
            alert("dislike " + $input.val());
        }
    });
		
	
	 
 });

</script>
</body>
</html>
