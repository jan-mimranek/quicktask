$(document).ready(function(){
    $.nette.init();
    
    $('.datepicker').datepicker({
        orientation: 'left top'
    });
    
    /*
     * Checkbox
     */
    $('input.task-checkbox').iCheck({
        handle:'checkbox',
        checkboxClass: 'icheckbox_minimal-blue',
    });
    
    $('input.task-checkbox').on('ifChecked', function (event) {
        var task_id = $(this).attr("id");
        sendCheckedTask('checked', task_id);
    });
    
    $('input.task-checkbox').on('ifUnchecked', function () {
        var task_id = $(this).attr("id");
        sendCheckedTask('unchecked', task_id);
    });
    
    $('frm-insertTaskForm-insertTaskForm').live('submit', function () {
        
        alert("A");
        
        return false;
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