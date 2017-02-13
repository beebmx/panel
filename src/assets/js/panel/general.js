var Panel = function() {
    function setIndex(){
        $('table.table .delete-data').on('click', function(event){
			event.preventDefault();
			var row = $(this).closest('tr')[0],
				text = $(row).children('td:first').html(),
				form = $(row).find('form');
			swal({
				title: "¡Cuidado!",
				text: '¿Realmente deseas eliminar el registro: <strong>'+text+'</strong>?',
				type: "warning",
				html: true,
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Eliminar",
				cancelButtonText: "Cancelar",
				closeOnConfirm: false
			},
			function(isConfirm){
				if (isConfirm) {
					form.submit();
				}
			});
		});
    }
    function getWindowSize(){
        $(window).resize(function() {
            if ($(window).width() > 992){
                $('body.beebmx-panel').removeClass('pushy-open-left');
            }
        });
    }
    function setMenuButtons(){
        $('.menu-btn').on('click', function(event){
            event.preventDefault();
        });
        $('.menu-bar').on('click', function(event){
            event.preventDefault();
        });
    }
    function handlerForm(){
        $(document).keydown(function(event) {
            if((event.ctrlKey || event.metaKey) && event.which === 83) {
                $('form.panel-form').submit();
                event.preventDefault();
                return false;
            }
        });
    }    
    return {
        index: function(){
            setIndex();
        },
        init: function(){
            handlerForm();
            getWindowSize();
            setMenuButtons();
        }
    };
}();