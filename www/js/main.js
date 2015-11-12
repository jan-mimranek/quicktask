$(document).ready(function(){
    $.nette.init();
    
    $('.datepicker').datepicker({
        orientation: 'left top'
    });
    /*
     * Checkbox iCheck
     */
    initializeICheck();
    /*
     * Mark Task as Checked
     */
    $('input.task-checkbox').on('ifChecked', function (event) {
        var task_id = $(this).attr("id");
        sendCheckedTask('checked', task_id);
    });
    /*
     * Mark Task as UnChecked
     */
    $('input.task-checkbox').on('ifUnchecked', function () {
        var task_id = $(this).attr("id");
        sendCheckedTask('unchecked', task_id);
    });
    /*
     * Task Filter Form
     */
    $("form.ajax.task-filter").on("submit", function (event) {
        sendTaskFilterForm( this );
        return false;
    });
    $("form.ajax.task-filter :submit").on("click", function (event) {
        sendTaskFilterForm( this );
        return false;
    });
    /*
     * Add New Task
     */
    $("form.ajax.insert-task").on("submit", function (event) {
        sendInsertTaskForm( this );
        return false;
    });
    $("form.ajax.insert-task :submit").on("click", function (event) {
        sendInsertTaskForm( this );
        return false;
    });
    /*
     * Task Group Selectbox change
     */
    $('select.task-group-seletbox').change(function(){
        sendTaskGroupChange( this );
    });

});

function sendTaskGroupChange( __this ){
    
    var value = __this.value;
    
    var form = $('form.task-filter');
    var data = getFormData(form);
    
    var task_id = $(__this).attr("id");
    
    data = data + '&taskGroupId='+value+'&taskId='+task_id;
    
    $.nette.ajax({
        type: 'POST',
        url: '?do=taskGroupChange'+data,
        complete: function(data) {
            initializeICheck();
        }
    });
};

function sendInsertTaskForm( __this ) {
    
    var insert_form = $(__this).closest('form');
    var insert_data = getFormData(insert_form);
    
    var filter_form = $('form.task-filter');
    var filter_data = getFormData(filter_form);

    var data = insert_data + filter_data;

    $.nette.ajax({
        type: 'POST',
        url: '?do=insertTask'+data,
        complete: function(data) {
            initializeICheck();
        }
    });
};


function sendTaskFilterForm( __this, handle_link ) {
    
    var form = $(__this).closest('form');
    var data = getFormData(form);

    $.nette.ajax({
        type: 'POST',
        url: '?do=taskFilter'+data,
        complete: function(data) {
            initializeICheck();
        }
    });
};

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

 function getFormData(form) {
     
     var array = form.serializeArray();
     var to_return = "";
     
     for (var key in array) {
         if (array[key].name !== 'do') {
             to_return = to_return + "&" + array[key].name + "=" + array[key].value
         }
     }
     
     return to_return;
 };
 
 /**
  * 
  * @returns {undefined}
  */
 function initializeICheck() {
    $('input.task-checkbox').iCheck({
        handle:'checkbox',
        checkboxClass: 'icheckbox_minimal-blue',
    });
 };
