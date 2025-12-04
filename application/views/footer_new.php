<div id="main-menu-bg"></div>
</div> 


<!-- Pixel Admin's javascripts -->

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


</body>
</html>