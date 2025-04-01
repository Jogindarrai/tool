<!-- footer -->
<script>
		jQuery(document).ready(function(){
			jQuery("form").validationEngine({promptPosition: 'topLeft'});
		});
</script>
<footer class="footer text-center">
    © <?= date('Y'); ?> AGAP & Co | All rights reserved
</footer>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        var inputValue = $(this).attr("value");
        $("." + inputValue).toggle();
    });

	    $('[data-toggle="tooltip"]').tooltip();
 $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });

$('.dropdown').on('show.bs.dropdown', function(e){
  $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
});

$('.dropdown').on('hide.bs.dropdown', function(e){
  $(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
});
});
</script>