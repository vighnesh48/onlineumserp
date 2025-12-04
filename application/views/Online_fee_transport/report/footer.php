<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->
<script src="<?=base_url()?>assets/javascripts/select2.min.js"></script>

<!-- Pixel Admin's javascripts -->
<script src="<?=base_url()?>assets/javascripts/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/javascripts/pixel-admin.min.js"></script>
<script type="text/javascript">
	init.push(function () {
		// Javascript code here
	})
	window.PixelAdmin.start(init);
	$("[data-toggle=popover]").each(function(i, obj) {

$(this).popover({
  html: true,
  content: function() {
    var id = $(this).attr('id')
    return $('#popover-content-' + id).html();
  }
});

});
</script>

<script>
					init.push(function () {
						$('#jq-datatables-example').dataTable();
						//$('#jq-datatables-example_wrapper .table-caption').text('Some header text');
						//$('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
					});
				</script>
</body>
</html>