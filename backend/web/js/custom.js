
jQuery.fn.extend({

    slugify: function()
    {
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

$(function ($) {

    $("#dataTable1").DataTable({'iDisplayLength': 20, "lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]]});
    $('#dataTable2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });

    // $(".wysihtml").wysihtml5();
    
    // CKEDITOR.replace();

    $('.autoslug').slugify();

    $(document).on( 'click', '.imageModal', function() { 
        $('#modalShowimage__view').attr('src', null);
        $('#modalShowimage__view').attr('src', $(this).attr('data-image'));
        $('#modalShowimage__title').text($(this).attr('data-title'));
    });
      
    $('#confirmDelete').on('show.bs.modal', function (e) {

        deleteUrl = $(e.relatedTarget).attr('data-action');

    });

    $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
        window.location = deleteUrl;
        return true;
    });

});

