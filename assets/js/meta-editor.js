jQuery (document).ready (function ($) {

    var newEntryAdded = false;

    function hideAjaxMsg($msg) {

        setTimeout(function() {
            $msg.fadeOut('fast');
        },3000);

    }

    /**
     * Update meta
     */

    $('.btn-update-meta').on('click',function() {

        var $btn = $(this);

        var $ajaxMsg = $btn.next('.ajax-msg');

        var $textArea = $('#meta-value-' + $btn.data('id'));

        if($textArea.length == 0) {
            return false;
        }

        var id = $textArea.data('id');
        var key = $textArea.data('key');

        var value = $textArea.val();

        var postData = {
            'umeta_id' : id,
            'meta_key' : key,
            'meta_value' : value
        };



        jQuery.ajax ({
            url        : ajaxUrlUpdateMeta,
            type       : 'POST',
            dataType   : 'JSON',
            data       : postData,
            beforeSend : function () {
                $btn.prop('disabled',true);

                $ajaxMsg.removeClass().addClass('ajax-msg text-info').html('Updating meta data, please wait ...').show();

            },
            success    : function (resp) {

                $btn.prop('disabled',false);

                if($.isPlainObject(resp)) {

                    if(resp.hasOwnProperty('code') && resp.hasOwnProperty('message')) {

                        if(resp.code > 0) {
                            $ajaxMsg.removeClass().addClass('ajax-msg text-success').html(resp.message).show();
                        } else {
                            $ajaxMsg.removeClass().addClass('ajax-msg text-danger').html(resp.message).show();
                        }

                        hideAjaxMsg($ajaxMsg);

                        return;
                    }

                }

                $ajaxMsg.removeClass().addClass('ajax-msg text-danger').html('Invalid response data!').show();

            },
            error      : function () {

                $btn.prop('disabled',false);

                $ajaxMsg.removeClass().addClass('ajax-msg text-danger').html('Error updating meta data due to network issues!').show();

                hideAjaxMsg($ajaxMsg);
            }
        });

    });

    /**
     * Delete meta
     */

    $('.btn-delete-meta').on('click',function() {

        var $btn = $(this);

        var $ajaxMsg = $btn.next('.ajax-msg');

        var id = $btn.data('id');
        var key = $btn.data('key');

        if(!confirm('Delete meta with key "' + key + '"?')) {
            return false;
        }

        var $metaBlock = $('#meta-block-' + id);

        var postData = {
            'umeta_id' : id,
            'meta_key' : key
        };

        jQuery.ajax ({
            url        : ajaxUrlDeleteMeta,
            type       : 'POST',
            dataType   : 'JSON',
            data       : postData,
            beforeSend : function () {
                $btn.prop('disabled',true);

                $ajaxMsg.removeClass().addClass('ajax-msg text-info').html('Deleting meta data, please wait ...').show();

            },
            success    : function (resp) {

                $btn.prop('disabled',false);

                if($.isPlainObject(resp)) {

                    if(resp.hasOwnProperty('code') && resp.hasOwnProperty('message')) {

                        if(resp.code > 0) {
                            $metaBlock.fadeOut('fast',function() {
                                $metaBlock.remove();
                            });
                        } else {
                            $ajaxMsg.removeClass().addClass('ajax-msg text-danger').html(resp.message).show();
                        }

                        hideAjaxMsg($ajaxMsg);

                        return;
                    }

                }

                $ajaxMsg.removeClass().addClass('ajax-msg text-danger').html('Invalid response data!').show();

            },
            error      : function () {

                $btn.prop('disabled',false);

                $ajaxMsg.removeClass().addClass('ajax-msg text-danger').html('Error updating meta data due to network issues!').show();

                hideAjaxMsg($ajaxMsg);
            }
        });

    });

    /**
     * Add Meta
     */

    $('#new-meta-form').on('submit',function() {

        var $form = $(this);

        var $btn = $form.find('button,input[type=submit]');

        var $ajaxMsg = $form.find('.ajax-msg');

        jQuery.ajax ({
            url        : ajaxUrlAddMeta,
            type       : 'POST',
            dataType   : 'JSON',
            data       : $form.serialize(),
            beforeSend : function () {
                $btn.prop('disabled',true);

                $ajaxMsg.removeClass().addClass('ajax-msg text-info').html('Adding meta data, please wait ...').show();

            },
            success    : function (resp) {

                $btn.prop('disabled',false);

                if($.isPlainObject(resp)) {

                    if(resp.hasOwnProperty('code') && resp.hasOwnProperty('message')) {

                        if(resp.code > 0) {
                            $ajaxMsg.removeClass().addClass('ajax-msg text-success').html(resp.message).show();

                            $('#new-meta-form').get(0).reset();

                            newEntryAdded = true;


                        } else {
                            $ajaxMsg.removeClass().addClass('ajax-msg text-danger').html(resp.message).show();
                        }

                        hideAjaxMsg($ajaxMsg);

                        return;
                    }

                }

                $ajaxMsg.removeClass().addClass('ajax-msg text-danger').html('Invalid response data!').show();

            },
            error      : function () {

                $btn.prop('disabled',false);

                $ajaxMsg.removeClass().addClass('ajax-msg text-danger').html('Error adding new meta data!').show();

                hideAjaxMsg($ajaxMsg);
            }
        });

        return false;

    });

    /**
     * Add key board shortcuts
     */

    $(document).off('keyup').on('keyup',function(e) {

        var $target = $(e.target);

        if($target.hasClass('typeable')) {
            return false;
        }

        var keyCode = e.keyCode;
        var shiftKey = e.shiftKey;

        if(shiftKey === true && keyCode == 65) {
            $('#link-add-meta').click();
        } else if(shiftKey === true && keyCode == 66) {
            window.location.href = $('#link-go-back').attr('href');
        }

    });

    $('#new-meta-modal').on('hide.bs.modal',function() {

        if(newEntryAdded) {
            window.location.href = window.location.href;
        }

    });

});