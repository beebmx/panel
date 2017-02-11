var Textarea = function() {
    function tinyMCE(path, e){
        var textarea = $(e),
            height  = textarea.attr('data-height') ? textarea.data('height') : 250,
            plugins = textarea.attr('data-plugins') ? [textarea.data('plugins')] : ['advlist autolink lists link image preview anchor media table contextmenu paste code'],
            toolbar = textarea.attr('data-toolbar') ? textarea.data('toolbar') : 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | preview code',
            frows   = $('#beebmx-panel-files tbody tr'),
            files = [];
        $(frows).each(function(i, f){
            files.push({title:$(f).data('basename'), value: $(f).data('uri')});
        });
        tinymce.init({
            selector         :'#'+e.id,
            entity_encoding  :'raw',
			language         :'es_MX',
			language_url     :path,
			menubar          :false,
			statusbar        :false,
			convert_urls     :false,
			image_advtab     :true,
			image_caption    :true,
			image_description:true,
			image_list       :files,
			height           :height,
			plugins          :plugins,
			toolbar          :toolbar
			
        });
    }
    return {
        init: function(path){
            $('textarea.textarea').each(function(i, e){
                tinyMCE(path, e);
            });
        }
    };
}();