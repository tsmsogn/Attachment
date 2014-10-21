/**
 * Require jQuery
 */
;(function ($) {

    if (typeof Attachment == undefined) {
        throw Error("Attachment undefined");
    }

    Attachment.browse = function(url, name, specs, replace) {
        window.open(url, name, specs, replace);
    }

    Attachment.attach = function (id, key) {
        $.ajax({
            type: 'GET',
            url: this.adminAttachUrl + '/' + id + '/' + key
        }).success(function (data) {
            window.top.opener.attachmentCallback(key, data);
            window.close();
        }).error(function (data) {
            window.top.opener.attachmentCallback(key, data, 1); // @TODO
        });
    }

    Attachment.detach = function (id, key) {
        $.ajax({
            type: 'GET',
            url: this.adminDetachUrl + '/' + id + '/' + key
        }).success(function (data) {
            attachmentCallback(key, data);
            window.close();
        }).error(function (data) {
            attachmentCallback(key, data, 1); // @TODO
        });
    }

    Attachment.attachToCKEditor = function(path) {
        window.top.opener.CKEDITOR.tools.callFunction(this.request.query.CKEditorFuncNum, path);
        window.top.close();
    }

})(jQuery);
