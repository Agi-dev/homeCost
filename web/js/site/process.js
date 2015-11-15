/**
 * Created by Francois on 08/11/2015.
 */
$(document).on('ready', function() {
    $('.btn-categ').on('click', function () {
        var id = $(this).closest('tr').data('id');
        var $label = $(this);
        var bClass = 'btn';
        var action = '';
        var msg = '';

        if ( $label.hasClass(bClass + '-default')){
            resetButtonClass(id);
            $label.removeClass(bClass + '-default');
            $label.addClass(bClass + '-success');
            action = 'tag';
            msg = 'Tag sauvegardé.'
        } else {
            $label.removeClass(bClass + '-success');
            $label.addClass(bClass + '-default');
            action = 'untag';
            msg = 'Tag supprimé.'
        }

        $.post('/site/' + action, {id: id, tagId: $label.data('id')})
            .done(function (data) {
                if (data.success) {
                    toastrSuccess(msg, true);
                } else {
                    ajaxFailed();
                }
            });
    });

    $('.ckb-ignore').on('change', function(){
        var $tr = $(this).closest('tr');
        var id = $tr.data('id');
        if ($(this).is(':checked')){
            $tr.addClass('danger');
            $tr.find('.btn').prop('disabled', true);
            resetButtonClass(id);
            $.post('/site/ignore', {id: id})
                .done(function (data) {
                    if (data.success) {
                        toastrSuccess('Opération ignorée', true);
                    } else {
                        ajaxFailed();
                    }
                });
        } else {
            $tr.removeClass('danger');
            $tr.find('.btn').prop('disabled', false);
            $.post('/site/keep', {id: id})
                .done(function (data) {
                    if (data.success) {
                        toastrSuccess('L\'opération n\'est plus ignorée.', true);
                    } else {
                        ajaxFailed();
                    }
                });
        }
    });
});

function resetButtonClass(id){
    var bClass = 'btn';
    var allCateg = $('.btn-id-'+ id);
    allCateg.removeClass(bClass + '-success');
    allCateg.addClass(bClass + '-default');
}
