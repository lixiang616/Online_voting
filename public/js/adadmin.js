$(document).ready(function () {
    $('.delete').click(function(e){
        if (!confirm('确定要此操作?')) {
            return false;
        }
        var id = $(this).attr('data-id');
        var token = $('input[name="token"]').val();
        var url = $(this).attr('data-redirect-url');
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : token }
        });
        var post_url = $(this).attr('data-post-url');
        $.post(post_url , { 'id' : id }, function(data){
            if (data.code) {
                showErrorMsg(data.msg);
                return false;
            }
            console.log(data);
            console.log(url);
            $(window).attr('location', url);
        }, 'json');
    })
    

    function showErrorMsg(errMsg) {
        var e = e || window.event;
        e.preventDefault();
        $('#myModal').modal('show');
        $('#myModal .modal-body p').html(errMsg);
    }

});