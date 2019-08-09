jQuery(document).ready(function () {
  var add_button = jQuery('.add_field_button ');
  var bsfppc_item_content = [];
  var drag_content = [];
  var input_feilds = jQuery('#add_item_text_feild[type="text"]');

  //Ajax trigger for adding an element in the array 
     jQuery(document).on('click', "#bsfppc-Savelist", function () {
     if(jQuery('.bsfppc-item-input').val().length !== 0){   
      console.log(jQuery('.bsfppc-item-input').attr('value'));
     jQuery('#bsfppc-ul').sortable();
    jQuery( "#bsfppc-ul" ).sortable( "destroy" );
      jQuery.post(bsfppc_add_delete_obj.url, {
          action: 'bsfppc_checklistitem_add',
          bsfppc_item_content: jQuery('.bsfppc-item-input').attr('value')
        },
        function (data) { 
          if (jQuery('.bsfppc-ul')[0]){
              jQuery(".bsfppc-ul").html(data);
          } else {
            data = '<ul id="bsfppc-ul" class="bsfppc-ul">'+data+'</ul>';
           jQuery(".bsfppcdragdrop").html(data);
          }    
      });
      jQuery('#bsfppc-ul').sortable({
          update: function () {
                  var item_drag_var = [];
                  var item_drag_var = jQuery('.bsfppc-drag-feilds');
                  item_drag_var.each(function () {
                    
                    drag_content.push(jQuery(this).attr('value'));
                  });
                  console.log(drag_content);
                    jQuery.post(bsfppc_add_delete_obj.url, {
                      action: 'bsfppc_checklistitem_drag',
                      item_drag_var: drag_content
                    }, function (data) {
                        if (data === 'sucess') {
                          drag_content = [];
                        } else if (data === 'failure') {
                          drag_content = [];
                        } else {
                          drag_content = [];
                        }
                      });
          }
      },
      { cancel: '.bsfppc-alreadyexists-waring-description' });
      jQuery('.bsfppc-item-input').val(""); 
    }else{
      jQuery(".bsfppc-hide-cover").css("visibility", "visible");  
      setTimeout(function() {
        jQuery(".bsfppc-hide-cover").css("visibility", "hidden");
      }, 2000);
    }
  });

  //Ajax trigger for deleting an element in the array
  jQuery(document).on('click', '.bsfppcdelete', function () {
    var txt;
    var r = confirm("Are you sure you want to delete ");
    if (r == true) {
      jQuery(this).parents('li:first').remove();
      jQuery.post(bsfppc_add_delete_obj.url, {
        action: 'bsfppc_checklistitem_delete',
        delete: jQuery(this).attr('value')
      }, function (data) {
        if (data === 'sucess') {
          
        } else {
          
        }
      });
    } else {
      txt = "You pressed Cancel!";
    }
  });

  jQuery(function () {
    jQuery('#bsfppc-ul').sortable({
      update: function () {
        var item_drag_var = [];
        var item_drag_var = jQuery('.bsfppc-drag-feilds');
        item_drag_var.each(function () {
          drag_content.push(jQuery(this).attr('value'));
        });console.log(drag_content);
        jQuery.post(bsfppc_add_delete_obj.url, {
          action: 'bsfppc_checklistitem_drag',
          item_drag_var: drag_content
        }, function (data) {
          if (data === 'sucess') {           
            drag_content = [];
          } else {
            drag_content = [];
          }
        });
      },
      cancel: '.bsfppc-alreadyexists-waring-description' 

    });
    jQuery('.bsfppc-ul').disableSelection();
  });
});
