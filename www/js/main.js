$(document).ready(function(){
    $.nette.init();

    $('.datepicker').datepicker({
        orientation: 'left top'
    });
    
    /** Check task */
    $('input.task-checkbox').change(function ( event ) {
        
        if( $(this).is(':checked') ) {
            sendCheckedTask('checked');
        } else {
            sendCheckedTask('unchecked');
        }

    });
    
});

/**
 * Ajax no checkbox state chege
 * 
 * @param string checked/unchecked
 */
function sendCheckedTask( param ) {
    $.nette.ajax({
        type: 'POST',
        url: '?do=checkTask&state='+param
    });
};