$(document).ready(function(){
    $(document).on('change','#libId',function(){
        var library_id = Number($(this).val());
        $.ajax({
            // url: App.base_path + '?r=site/books',
            url: '?r=site/books',
            type: 'POST',
            data: {
               library_id: library_id
           },
           success: function(res){
                $('#book-checkboxes').html(res);
                if (library_id !== '') {
                    $('#my-button').show();
                } else {
                    $('#my-button').hide();
                }
           }
        });
   });
    $(document).on('click','.select-all',function(){
        $('.book-checkbox').prop('checked', $(this).prop('checked'));
    });
});


// $('#select-all').click(function(){
//     $('.book-checkbox').prop('checked', $(this).prop('checked'));
// });



