/**
 * Functions for login page
 */

$(document).ready(function(){
   if ($('.datepicker').length > 0) {  
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',                           
            clearBtn: true,
            todayHighlight: true,
            autoclose: true
        }); 
    }
});
