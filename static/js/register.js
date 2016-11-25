/** @param {jQuery} $ jQuery Object */
!function($, window, document, _undefined)
{
    Public.passwordStrength = function($input)
    {
        var $meter = $('.PasswordMeter > .Strength'),
            strengthCheck = function()
            {
                var result = zxcvbn($input.val()),
                    color = '#BF3100';

                switch (result['score'])
                {
                    case 4:
                        color = '#B4D304';
                        break;

                    case 3:
                        color = '#F5BB00';
                        break;

                    case 2:
                        color = '#FF4E00';
                }

                $meter.css(
                    {
                        background: color,
                        width: (result['score'] / 4) * 100 + '%'
                    });
            };

        window.setInterval(strengthCheck,200);
    };

    XenForo.register('.Password', 'Public.passwordStrength');
}
(jQuery, this, document);