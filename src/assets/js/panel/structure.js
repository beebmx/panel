var Structure = function() {
    function setStructure(e){
        var structure = $(e),
            id = structure.data('structure'),
            table = $('table#table-'+id),
            header = String(table.data('header')).split('|'),
            fields = String(structure.data('fields')).split('|'),
            head = table.children('thead'),
            body = table.children('tbody'),
            row = document.createElement('tr'), th;
        
        $.each(header, function(i, h){
            th = $(document.createElement('th')).html(h);
            $(row).append(th);
        });
        
        th = $(document.createElement('th')).html('');
        $(row).append(th);
        
        head.append(row);
        writeTable(id);
        
        $('#modal-'+id).on('show.bs.modal', function (event) {
            var modal = $(this), 
                target = $(event.relatedTarget);
            if (target.length){
                var json = structure.val() !== '' ? JSON.parse(structure.val()) : [],
                    data = target.data('data'),
                    index = target.data('index'),
                    form = modal.find('form'),
                    save = modal.find('.save-structure'),
                    obj = {}, field, value, vjson = [],
                    current_field, modal_action = 'new';
                
                if (typeof data === 'undefined'){
                    modal_action = 'new';
                }else{
                    modal_action = 'edit';
                    obj = JSON.parse(data);
                    $.each(fields, function(i,f){
                        field = modal.find('#modal-'+f);
                        field.val(obj[f]);
                        if (field.hasClass('textarea')){
                            tinymce.get('modal-'+f).setContent(obj[f]);
                        }
                        if (field.hasClass('checkbox')){
                            if (obj[f]) {
                                $(field).prop('checked', true);
                            }
                        }
                        if (modal.find('input[name="modal-'+f+'[]"]').length){
                            $.each(obj[f], function(mci, vci){
                                $.each(modal.find('input[name="modal-'+f+'[]"]'), function(mcj, vcj){
                                    if (vcj.value === vci){
                                        $(vcj).prop('checked', true);
                                    }
                                });
                            });
                        }
                    });
                }
                
                $(save).on('click', function(evt){
                    $(save).off('click');
                    if (modal.find('textarea.textarea').length){
                        tinymce.triggerSave();
                    }
                    $.each(fields, function(i,f){
                        current_field = modal.find('#modal-'+f);
                        value = current_field.val();
                        
                        if (current_field.hasClass('checkbox')){
                            value = current_field.is(':checked') ? 1 : 0;
                        }
                        if (typeof value === 'undefined'){
                            $.each(modal.find('input[name="modal-'+f+'[]"]:checked'), function(i, vj){
                                vjson.push($(vj).val());
                            });
                            value = vjson;
                        }
                        obj[f] = value;
                    });
                    if (modal_action === 'new'){
                        json.push(obj);
                    }else{
                        json[index] = obj;
                    }
                    structure.val(JSON.stringify(json));
                    writeTable(id);
                    modal.modal('hide');
                });
            }
        });
        
        $('#modal-'+id).on('hidden.bs.modal', function (event) {
            var modal = $(this), 
                form = modal.find('form'),
                save = modal.find('.save-structure');
            form[0].reset();
            $(save).off('click');
        });
    }
    function writeTable(id){
        var field = $('#'+id),
            json = field.val() !== '' ? JSON.parse(field.val()) : [],
            table = $('table#table-'+id),
            tbody = table.children('tbody'),
            fields = String(table.data('fields')).split('|'),
            data = field.val() !== '' ? JSON.parse(field.val()) : [],
            row, cell, edit, trash;
            tbody.html('');
            $.each(data, function(i, e){
                row = document.createElement('tr');
                $.each(fields, function(j, f){
                    $(row.insertCell(-1)).html(e[f]);
                });
                cell = row.insertCell(-1);
                edit = $(document.createElement('a'));
                edit.html('<i class="material-icons">mode_edit</i>').attr('href', '#')
                                                      .attr('data-toggle', 'modal')
                                                      .attr('data-target', '#modal-'+id)
                                                      .data('index', i)
                                                      .data('data', JSON.stringify(e));
                trash = $(document.createElement('a'));
                trash.html('<i class="material-icons">delete</i>').attr('href', '#')
                                                                  .addClass('element-delete')
                                                                  .data('index', i);
                $(cell).append(edit);
                $(cell).append(trash);
                $(row).append(cell);
                tbody.append(row);
            });
            table.find('.element-delete').on('click', function(event){
                event.preventDefault();
                json.splice($(this).data('index'), 1);
                field.val(JSON.stringify(json));
                writeTable(id);
            });
    }
    function setView(e){
        var structure = $(e),
            id = structure.data('structure'),
            json = structure.val() !== '' ? JSON.parse(structure.val()) : [],
            table = $('table#table-'+id),
            header = String(table.data('header')).split('|'),
            fields = String(structure.data('fields')).split('|'),
            head = table.children('thead'),
            body = table.children('tbody'),
            row = document.createElement('tr'), th;
        
        $.each(header, function(i, h){
            th = $(document.createElement('th')).html(h);
            $(row).append(th);
        });
        
        head.append(row);
        viewTable(id);
    }
    function viewTable(id){
        var field = $('#'+id),
            json = field.val() !== '' ? JSON.parse(field.val()) : [],
            table = $('table#table-'+id),
            tbody = table.children('tbody'),
            fields = String(table.data('fields')).split('|'),
            data = field.val() !== '' ? JSON.parse(field.val()) : [],
            row, cell, edit, trash;
            tbody.html('');
            $.each(data, function(i, e){
                row = document.createElement('tr');
                $.each(fields, function(j, f){
                    $(row.insertCell(-1)).html(e[f]);
                });
                tbody.append(row);
            });
    }
    return {
        init: function(){
            $('a.modal-add').on('click', function(e){
                e.preventDefault();
            });
            $('input.structure').each(function(i, e){
                setStructure(e);
            });
        },
        view: function(){
            $('input.structure').each(function(i, e){
                setView(e);
            });
        }
    };
}();