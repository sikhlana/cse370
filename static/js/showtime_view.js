/** @param {jQuery} $ jQuery Object */
!function($, window, document, _undefined)
{
    Public.seatSelection = function($container)
    {
        $container.find('button.seat').click(function(e)
        {
            var self = $(this);
            e.preventDefault();

            if ($(this).hasClass('disabled'))
            {
                return false;
            }

            var selected = self.hasClass('selected');

            XenForo.ajax($container.data('link'),
                {
                    'seat_number': self.data('seat-number'),
                    'ticket_grade': self.data('ticket-grade'),
                    'ticket_price': self.data('ticket-price')
                }, function(ajaxData)
                {
                    if (XenForo.hasResponseError(ajaxData))
                    {
                        return;
                    }

                    if (ajaxData.removed)
                    {
                        self.removeClass('selected');
                    }
                    else
                    {
                        self.addClass('selected');
                    }
                });
        });
    };

    XenForo.register('.SeatSelection', 'Public.seatSelection');
}
(jQuery, this, document);