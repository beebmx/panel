var File = function() {
    var files = [], uploaded = [], id = 0, tbody, row, fileIcon, uploadedFiles = 0, totalFiles = 0;
    var eventFile = {
        add: new CustomEvent("fileAdd", {detail: {add: true}}),
        del: new CustomEvent("fileDel", {detail: {del: true}})
    };
    
    var settings = function(config){
        $('#beebmx-panel-fileupload').fileupload({
            autoUpload: false,
			paramName: 'file',
			multipart: true,
			maxFileSize: config.size * 1024 * 1024,
			previewMaxWidth: 40,
	        previewMaxHeight: 40,
	        previewCrop: false
        }).on('fileuploadprocessalways', function (evt, data) {
            var f = data.files[0], row, i, index = searchRow(f.name);
            if (typeof(f.error) === 'undefined'){
                fileIcon = getTypeIcon(f.type, f);
        		if (index !== false){
                    row = $('#beebmx-panel-files tbody tr').eq(index-1);
        			$(row).children('td').eq(2).html(getFileSize(f.size));
        			if (!$(row).data('remote')){
            			i = searchFile (f.name);
            			files[i] = data;
            			$(row).data('file', data);
        			}else{
            			$(row).data('file', data);
            			$(row).data('remote', false);
            			files.push(data);
        			}
    			}else{	
        			row = document.createElement('tr');
        			$(row.insertCell(-1)).html(fileIcon);
        			$(row.insertCell(-1)).html(f.name);
        			$(row.insertCell(-1)).html(getFileSize(f.size)).addClass('hidden-xs');
        			$(row.insertCell(-1)).html('<a href="#" class="btn btn-transparent btn-md row-remove"><i class="material-icons">delete</i></a>');
        			$(row).data('file', data);
        			$(row).data('remote', false);
        			$(row).data('basename', f.name);
        			$('#beebmx-panel-files tbody').append(row);
        			files.push(data);
    			}
    			deleteHandler();
			}else{
    			console.log('error', f.error);
			}
        }).on('fileuploadprogressall', function(evt, data){
            var totalProgress = (uploadedFiles * 100) / totalFiles,
                progress = ((parseInt(data.loaded / data.total * 100, 10)) / totalFiles ) + totalProgress;
            $('#beebmx-panel-files .progress > .progress-bar').css('width', progress + '%');
        }).on('fileuploaddone', function(e, data){
            uploadedFiles++;
            files.shift();
            uploaded.push({file:data.files[0].name, action:'add'});
			upload();
        });
    };
    var deleteHandler = function(){
		$('#beebmx-panel-files tbody .row-remove').off('click').on('click', function(event){
			event.preventDefault();
			document.dispatchEvent(eventFile.del);
			var row = $(this).parent().parent(), i, del, file;
			if (!$(row).data('remote')){
    			file = $(row).data('file');
    			i = searchFile (file.files[0].name);
    			files.splice(i, 1);
			}else{
    			uploaded.push({file:$(row).data('basename'), action:'delete'});
			}
			del = searchRow($(row).data('basename'));
			$('#beebmx-panel-files tbody tr').eq(del-1).remove();
		});	
	};
	var searchFile = function(basename){
    	var i = false;
    	$.each(files, function(index, f){
			if (basename === f.files[0].name){
				i = index;
			}
		});
		return i;
	};
	var searchRow = function(basename){
    	var index = false;
    	$('#beebmx-panel-files tbody tr').each(function(i, f){
        	if (basename === $(this).data('basename')){
            	index = this.rowIndex;
        	}
    	});
    	return index;
	};
	var getFileSize = function(bytes){
        if (typeof bytes !== 'number'){
            return '';
        }
        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }
        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }
        return (bytes / 1000).toFixed(2) + ' KB';
    };
    var makeCanvas = function(image, element){
		var canvas, img = new Image();
		canvas = document.createElement("canvas");
		canvas.width = 40;
		canvas.height = 40;
		img.src = image;
		img.onload = function(){
			var scale = Math.min((70/img.width),(70/img.height));
			canvas.getContext("2d").drawImage(img, 0, 0, img.width, img.height,
            								 (canvas.width-img.width*scale)/2, (canvas.height-img.height*scale)/2, 
            								  img.width*scale, img.height*scale);
			element.html(canvas);
		};
	};
	var rowFile = function(){
		var preview, rows = $('body.form #beebmx-panel-files tbody tr');
		if (rows.length){
			$.each(rows, function(i, row){
				var fileIcon = getTypeIcon($(row).data('mime'), false, row);
				if (fileIcon){
    				$(row).children('td').eq(0).html(fileIcon);
				}
			});
		}
		deleteHandler();
	};
	var getTypeIcon = function(type, f, row){
    	document.dispatchEvent(eventFile.add);
    	var fileIcon = false;
    	switch(type){
			case "image":
			case "image/jpeg":
			case "image/gif":
            case "image/png":
                if (f){ fileIcon = f.preview; }
                else{ 
                    fileIcon = '<span class="file-viewer"><img src="'+$(row).data('thumb')+'" /></span>';
                    //makeCanvas($(row).data('uri'), $(row).children('td').eq(0));
                }
            break;
            default:
            	fileIcon = '<span class="file-icon"><i class="material-icons">insert_drive_file</i></span>';
        }
        return fileIcon;
	};
    var submit = function(){
        $('form.panel-form').on('submit', function(event){
            event.preventDefault();
            if (!files.length){
                $('#beebmx_panel_files_uploaded').val(JSON.stringify(uploaded));
				this.submit();
			}else{
    			totalFiles = files.length;
				upload();
			}
        });
    };
    var upload = function(){
        if (files.length){
			files[0].submit();
		}else{
			$('form.panel-form').submit();
		}
    };
    return {
        init: function(config){
            settings(config);
            submit();
            rowFile();
        }
    };
}();