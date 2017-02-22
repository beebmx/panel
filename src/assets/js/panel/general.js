var Panel = function() {
    function setIndex(){
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