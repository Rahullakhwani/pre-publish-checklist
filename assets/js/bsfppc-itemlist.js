jQuery(document).ready(function() {
    var add_button = jQuery('.add_field_button ');
    var bsfppc_item_content = [];
    var bsfppc_drag_contents = [];
    var input_feilds = jQuery('#add_item_text_feild[type="text"]');

    //Ajax trigger for adding an element in the array 
    jQuery(document).on('click', "#bsfppc-Savelist", function() {
        var bsfppc_input_item = jQuery('.bsfppc-item-input').val()
        var bsfppc_item_drag_var = [];
        var bsfppc_item_drag_var = jQuery('.bsfppc-drag-feilds');
        bsfppc_item_drag_var.each(function() {

            bsfppc_drag_contents.push(jQuery(this).attr('value'));
        });
        if (jQuery.inArray(bsfppc_input_item, bsfppc_drag_contents) !== -1) {
            var bsfppc_item_exists = 1;
            console.log(bsfppc_item_exists);

        } else {
            var bsfppc_item_exists = 0;
            console.log(bsfppc_item_exists);
        }

        console.log(jQuery('.bsfppc-item-input').val());
        if (jQuery('.bsfppc-item-input').val().replace(/ /g, '').length !== 0 && bsfppc_item_exists !== 1) {
            jQuery('.bsfppc-empty-list').attr('style', 'visibility:hidden');
            jQuery('#bsfppc-ul').sortable();
            jQuery("#bsfppc-ul").sortable("destroy");
            jQuery.post(bsfppc_add_delete_obj.url, {
                    action: 'bsfppc_checklistitem_add',
                    bsfppc_item_content: jQuery('.bsfppc-item-input').attr('value')
                },
                function(data) {
                    if (jQuery('.bsfppc-ul')[0]) {
                        jQuery(".bsfppc-ul").html(data);
                    } else {
                        data = '<ul id="bsfppc-ul" class="bsfppc-ul">' + data + '</ul>';
                        jQuery(".bsfppcdragdrop").html(data);
                    }
                });
            jQuery('#bsfppc-ul').sortable({
                update: function() {
                    jQuery(this).sortable("disable");
                    var bsfppc_item_drag_var = [];
                    var bsfppc_item_drag_var = jQuery('.bsfppc-drag-feilds');
                    bsfppc_item_drag_var.each(function() {
                        bsfppc_drag_contents.push(jQuery(this).attr('value'));
                    });
                    jQuery.post(bsfppc_add_delete_obj.url, {
                        action: 'bsfppc_checklistitem_drag',
                        bsfppc_item_drag_var: bsfppc_drag_contents
                    }, function(data) {
                        if (data === 'sucess') {
                            bsfppc_drag_contents = [];
                            jQuery('#bsfppc-ul').sortable("enable");
                        }
                    });
                },
                placeholder: "dashed-placeholder"
            });
            jQuery('.bsfppc-item-input').val("");
        } else {

            jQuery(".bsfppc-hide-empty-warning").css("visibility", "visible");
            if (bsfppc_item_exists == 1) {
                jQuery(".bsfppc-list-waring-description").html('List item already exists');
            } else {
                jQuery(".bsfppc-list-waring-description").html('List item cannot be empty');
            }
            setTimeout(function() {
                jQuery(".bsfppc-hide-empty-warning").css("visibility", "hidden");
            }, 2000);
        }


    });

    //Ajax trigger for deleting an element in the array
    jQuery(document).on('click', '.bsfppcdelete', function() {

        // console.log(jQuery(this).prop("name")== 'Delete');
        if (jQuery(this).prop("name") == 'Delete') {

            var bsfppc_txt;
            var bsfppc_delete_flag = confirm("Are you sure you want to Delete ");
            if (bsfppc_delete_flag == true) {
                jQuery(this).parents('li:first').remove();
                jQuery.post(bsfppc_add_delete_obj.url, {
                    action: 'bsfppc_checklistitem_delete',
                    delete: jQuery(this).attr('value')
                }, function(data) {
                    if (data === 'sucess') {

                    } else {

                    }
                });
            } else {
                bsfppc_txt = "You pressed Cancel!";
            }
        } else if (jQuery(this).prop("name") == 'Save') {
            jQuery('.bsfppc-drag-feilds').attr('style', 'width:79%');
            jQuery('.bsfppcedit').attr('style', 'display:inline-block');

            if (jQuery(this).prevUntil(".dashicons-menu-alt2", ".bsfppc-drag-feilds").val().replace(/ /g, '').length !== 0) {

                jQuery(this).attr("name", "Delete");
                jQuery(this).html('<span class="dashicons dashicons-trash bsfppc-delete-dashicon"></span>Delete');
                jQuery('.bsfppc-drag-feilds').attr('readonly', true);
                if (jQuery(this).val() != jQuery(this).prevUntil(".dashicons-menu-alt2", ".bsfppc-drag-feilds").val()) {

                    jQuery.post(bsfppc_add_delete_obj.url, {
                        action: 'bsfppc_checklistitem_edit',
                        bsfppc_edit_value: jQuery(this).prevUntil(".dashicons-menu-alt2", ".bsfppc-drag-feilds").val(),
                        bsfppc_prev_value: jQuery(this).val()
                    }, function(data) {
                        if (data === 'sucess') {

                        } else {



                        }
                    });
                }

            }
            jQuery(this).attr("value", jQuery(this).prev().val());
            jQuery("#bsfppc-ul").sortable("enable");


        } else if (jQuery(this).prev().val().length == 0) {
            jQuery(".bsfppc-hide-cover").css("visibility", "visible");
            setTimeout(function() {
                jQuery(".bsfppc-hide-cover").css("visibility", "hidden");
            }, 2000);
        }
        if (jQuery(".bsfppc-drag-feilds").length == 0) {
            jQuery('.bsfppc-empty-list').attr('style', 'visibility:visible');
        } else if (jQuery(".bsfppc-drag-feilds").length !== 0) {
            jQuery('.bsfppc-empty-list').attr('style', 'visibility:hidden');
        }
    });

    jQuery('#bsfppc-ul').sortable({
        update: function() {
            jQuery(this).sortable("disable");
            var bsfppc_item_drag_var = [];
            var bsfppc_item_drag_var = jQuery('.bsfppc-drag-feilds');
            bsfppc_item_drag_var.each(function() {
                bsfppc_drag_contents.push(jQuery(this).attr('value'));
            });
            jQuery.post(bsfppc_add_delete_obj.url, {
                action: 'bsfppc_checklistitem_drag',
                bsfppc_item_drag_var: bsfppc_drag_contents
            }, function(data) {
                if (data === 'sucess') {
                    bsfppc_drag_contents = [];
                    jQuery('#bsfppc-ul').sortable("enable");
                }
            });
        },
        placeholder: "dashed-placeholder"
    }, {
        cancel: '.bsfppc-alreadyexists-waring-description'
    });

    jQuery(document).on('click', '.bsfppcedit', function() {
        jQuery(".bsfppc-drag-feilds").each(function() {
            jQuery(this).attr('style', 'cursor:default');
        })
        jQuery(this).attr('style', 'display:none');
        jQuery(this).prev().attr('style', 'width:87%');
        jQuery("#bsfppc-ul").sortable("disable");
        jQuery(this).prev().removeAttr('readonly');
        jQuery(this).prev().focus();
        jQuery(this).parent('.bsfppc-li').find(".bsfppcdelete").html('<span class="dashicons dashicons-portfolio"></span> Save');
        jQuery(this).parent('.bsfppc-li').find(".bsfppcdelete").attr("name", "Save");
    });
    console.log(jQuery(".bsfppc-li").length);
    if (jQuery(".bsfppc-drag-feilds").length == 0) {
        jQuery('.bsfppc-empty-list').attr('style', 'visibility:visible');
    } else if (jQuery(".bsfppc-drag-feilds").length !== 0) {
        jQuery('.bsfppc-empty-list').attr('style', 'visibility:hidden');
    }

});