var Colorpicker = function() {
    function setOptions(e){
        var element = $(e),
            hasPalette = element.attr('data-colors') ? true : false,
            colors = String(element.data('colors')).split('|'),
            palette = [], tp = [], tmp;
        
        $.each(colors, function(i, color){
            tmp = String(color).split(',');
            if (tmp.length === 1){
                palette.push('#'+tmp[0]);
            }else{
                tp = [];
                $.each(tmp, function(j, c){
                    tp.push('#'+c);
                });
                palette.push(tp);
            }
        });
		element.spectrum({
			preferredFormat        :"hex",
			showInput              :true,
			showPalette            :hasPalette,
			palette                :palette,
			hideAfterPaletteSelect :true,
			allowEmpty             :true
		});
    }
    return {
        init: function(){
            $('input.color').each(function(i, e){
                setOptions(e);
            });
        }
    };
}();