(function ($){
    $(document).ready( function () {
        var $arrowGap = $('#br-pagination-arrow-gap');
        var $orientation = $('[name="br-pagination-options[style_settings][ul_li_style][float]"]');
        function paginationDesign() {
            var design = $('#br-pagination-design').val();
            if (!design) { return; }
            var manual = design === 'manual';
            $('.br-pagination-manual-styles').toggle(manual);
            $('#br-pagination-design-preview').prop('hidden', manual);
            if (!manual) {
                var gap = $arrowGap.val();
                var hasGap = /^[0-9]+$/.test(gap) && gap > 0 && gap <= 64;
                var vertical = $orientation.val() === 'none';
                var $preview = $('#br-pagination-design-preview nav');
                $preview.attr('class', 'woocommerce-pagination berocket_pagination br-pagination-preset br-pagination-preset--' + design)
                    .toggleClass('br-pagination-preset--vertical', vertical)
                    .toggleClass('br-pagination-arrow-gap', hasGap)
                    .toggleClass('br-pagination-arrow-gap--vertical', hasGap && vertical);
                $preview[0].style.setProperty('--br-pagination-arrow-gap', hasGap ? gap + 'px' : '');
            }
        }
        $('#br-pagination-design').on('change', paginationDesign);
        $arrowGap.on('input', paginationDesign);
        $orientation.on('change', paginationDesign);
        $('#br-pagination-design-preview').on('click', 'a', function(event) { event.preventDefault(); });
        paginationDesign();
        function block_changer( input_class ) {
            if ( $( '.'+input_class ).is('[type=checkbox]') ) {
                $( '.'+input_class ).change( function () {
                    if ( $(this).prop('checked') ) {
                        $( '.'+input_class+'_1').show();
                        $( '.'+input_class+'_0').hide();
                    } else {
                        $( '.'+input_class+'_0').show();
                        $( '.'+input_class+'_1').hide();
                    }
                });
                if ( $( '.'+input_class ).prop('checked') ) {
                    $( '.'+input_class+'_1' ).show();
                    $( '.'+input_class+'_0' ).hide();
                } else {
                    $( '.'+input_class+'_0' ).show();
                    $( '.'+input_class+'_1' ).hide();
                }
            } else if ( $( '.'+input_class ).is('select') ) {
                $( '.'+input_class ).change( function () {
                    var val = $(this).val();
                    $( '.'+input_class+'_blocks' ).hide();
                    $( '.'+input_class+'_'+val ).show();
                });
                var val = $( '.'+input_class ).val();
                $( '.'+input_class+'_blocks' ).hide();
                $( '.'+input_class+'_'+val ).show();
            }
        }
        block_changer( 'berocket_use_dots_text' );
        block_changer( 'berocket_use_next_prev_text' );
        block_changer( 'berocket_pagination_type' );
        $(document).on('change', '.br_use_spec_styles', function() {
            if( $(this).prop('checked') ) {
                $('.berocket_pagi_styles_'+$(this).data('id')).show();
            } else {
                $('.berocket_pagi_styles_'+$(this).data('id')).hide();
            }
        });
    });
})(jQuery);
