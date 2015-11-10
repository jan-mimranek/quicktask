$(document).ready(function(){
    $.nette.init();
    
    $('.datepicker').datepicker({
        orientation: 'left top'
    });
    
    /** Check task */
    
    $('input.task-checkbox').iCheck({
        handle:'checkbox',
        checkboxClass: 'icheckbox_minimal-blue',
    });
    
    $('input.task-checkbox').change(function ( event ) {
        
        var task_id = $(this).attr("id");
        
        console.log(task_id);
        
        if( $(this).is(':checked') ) {
            sendCheckedTask('checked', task_id);
        } else {
            sendCheckedTask('unchecked', task_id);
        }

    });
    
});

/**
 * Ajax no checkbox state chege
 * 
 * @param string checked/unchecked
 */
function sendCheckedTask( param, task_id ) {
    $.nette.ajax({
        type: 'POST',
        url: '?do=checkTask&state='+param+'&task_id='+task_id
    });
};