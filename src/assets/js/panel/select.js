var Select = function() {
    var getAllFiles = function(){
        var files = [],
            rows = $('#beebmx-panel-files tbody tr');
        $(rows).each(function(i, e){
            files.push($(e.cells[1]).text());
        });
        return files;
    };
    var setList = function(obj, list){
        var select = $(obj),
            first = select.find('option').first();
        select.find('option').remove();
        select.append(first);
        $.each(list, function(i, e){
            select.append('<option value="'+e+'">'+e+'</option>');
        });
    };
    var reviewType = function(isInit){
        var select = $('select.dynamic');
        select.each(function(i, e){
            switch ($(e).data('type')){
                case 'file':
                    setList(e, getAllFiles());
                break;
            }
            if (isInit) {
                $(e).val($(e).data('init'));
            }
        });
    };
    var handler = function(){
        document.addEventListener("fileAdd", function(e) {
            setTimeout(function(){
                reviewType(false);
            });
        });
        document.addEventListener("fileDel", function(e) {
            setTimeout(function(){
                reviewType(false);
            });
        });
    };
    var populate = function(){
        reviewType(true);
    };
    return {
        init: function(){
            handler();
            populate();
        }
    };
}();