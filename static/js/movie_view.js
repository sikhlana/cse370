/** @param {jQuery} $ jQuery Object */
!function($, window, document, _undefined)
{
    Public.fixTrailerWidth = function($container)
    {
        $container.fitVids();
    };

    Public.ratingField = function($container)
    {
        var stars = $container.find('.Star');

        stars.html('<i class="fa fa-star-o"></i>');

        stars.hover(function()
        {
            var self = $(this),
                hover = function($item)
                {
                    $item.html('<i class="fa fa-star"></i>').addClass('hovered');
                };

            hover(self);

            for (var i = 0; i < self.index(); i++)
            {
                hover(stars.eq(i));
            }

        }, function()
        {
            var self = $(this),
                unhover = function($item)
                {
                    $item.html('<i class="fa fa-star-o"></i>').removeClass('hovered');
                };

            for (var i = 0; i < stars.size(); i++)
            {
                if (!stars.eq(i).hasClass('selected'))
                {
                    unhover(stars.eq(i));
                }
            }
        });

        stars.click(function()
        {
            var self = $(this),
                click = function($item)
                {
                    $item.html('<i class="fa fa-star"></i>').addClass('selected');
                };

            stars.removeClass('selected');

            click(self);
            $container.find('.RatingFieldInput').val(self.index() + 1);

            for (var i = 0; i < self.index(); i++)
            {
                click(stars.eq(i));
            }

            var unhover = function($item)
            {
                $item.html('<i class="fa fa-star-o"></i>').removeClass('hovered');
            };

            for (i = 0; i < stars.size(); i++)
            {
                if (!stars.eq(i).hasClass('selected'))
                {
                    unhover(stars.eq(i));
                }
            }
        });
    };

    XenForo.register('.movieTrailer', 'Public.fixTrailerWidth');
    XenForo.register('.RatingField', 'Public.ratingField');
}
(jQuery, this, document);