
jQuery.fn.extend({

    slugify: function() {
        $(this).keyup( function(){
            var target = $(this).attr('slug-target');
            var result = $(this).val().toString().toLowerCase()
              .replace(/\s+/g, '-')           // Replace spaces with -
              .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
              .replace(/\-\-+/g, '-')         // Replace multiple - with single -
              .replace(/^-+/, '')             // Trim - from start of text
              .replace(/-+$/, '')             // Trim - from end of text
              .replace(/[\s_-]+/g, '-');
            
            $(target).val(result);
        }); 
    }
});

$('#dataTableAjax').dataTable({
    "sDom" : "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", //default layout without horizontal scroll(remove this setting to enable horizontal scroll for the table)
    "iDisplayLength": 10,
    "bProcessing": true,
    "bServerSide": true,
    "sAjaxSource": "{{ url([ app.controller.id ~ '/list-of-data']) }}",
    // set the initial value
    "oLanguage": {
        "sProcessing": '<i class="fa fa-coffee"></i>&nbsp;Please wait...',
        "sLengthMenu": "_MENU_ records",
        "oPaginate": {
            "sPrevious": "Prev",
            "sNext": "Next"
        }
    },
    "ordering": false
});


$("#dataTable1").DataTable({'iDisplayLength': 10});
$('#dataTable2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": true
});

$(".wysihtml").wysihtml5();

$('.autoslug').slugify();
