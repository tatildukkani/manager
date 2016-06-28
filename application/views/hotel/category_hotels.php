<? //print_r($hotels); ?>
<div class="panel panel-flat">
						

						<table class="table datatable-basic">
							<thead>
								<tr>
									<th>Otel</th>
									<th>Ülke</th>
									<th>Şehir</th>
									<th>Bölge</th>
									<th>Konsept</th>
									<th>Fiyat</th>
                                    <th>Puan</th>
                                   
								</tr>
							</thead>
							<tbody>
                            <?php for($i=0; $i<count($hotels); $i++){  ?>
								<tr>
									<td><?php print $hotels[$i]['attrs']['name']; ?></td>
									<td><?php print $hotels[$i]['attrs']['country']; ?></td>
									<td><?php print $hotels[$i]['attrs']['city']; ?></td>
									<td><?php print $hotels[$i]['attrs']['district']; ?></td>
									<td><?php print $hotels[$i]['attrs']['concept']; ?></td>
									<td><?php print $hotels[$i]['attrs']['net_fee']; ?> TL</td>
                                    <td><?php print $hotels[$i]['attrs']['point']; ?></td>
                                   
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
					<!-- /basic datatable -->
                    
<script>
$(document).ready(function() {
	$('.datatable-basic').DataTable();
});
</script>