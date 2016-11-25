/** @param {jQuery} $ jQuery Object */
!function($, window, document, _undefined)
{
    var Public = {};

    XenForo.alert = function(message, messageType, timeOut, onClose)
    {
        message = String(message || 'Unspecified error');

        swal({
            title: timeOut ? 'Success!' : 'Oops!',
            text: message,
            html: true,
            type: timeOut ? 'success' : 'error',
            allowOutsideClick: true,
            timer: timeOut || null
        }, onClose);
    };

    Public.deleteConfirm = function($button)
    {
        $button.click(function(e)
        {
            e.preventDefault();

            swal({
                    title: "Are you sure?",
                    text: "The change will be permanent!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm)
                {
                    if (isConfirm)
                    {
                        XenForo.redirect($button.attr('href') || $button.attr('data-href'));
                    }
                });
        });
    };

    Public.formValidation = function($form)
    {
        $form.on('AutoValidationError', function(e)
        {
            e.preventDefault();
            var message = 'An error occurred.';

            if (e.ajaxData.error)
            {
                message = e.ajaxData.error[0];
            }

            XenForo.alert(message, 'error');
        });
    };

    window.Public = Public;
    XenForo.register('.DeleteConfirm', 'Public.deleteConfirm');
    XenForo.register('form.AutoValidator', 'Public.formValidation');
}
(jQuery, this, document);