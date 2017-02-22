 $(function ($) {
    if ($('.datetimepicker').length){
    	var locale = $('.datepicker .input').attr('data-locale');
        $('.datetimepicker').datetimepicker({
        	locale: locale,
            allowInputToggle: true,
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm'
        });
    }
 });
