$(document).ready(
    function() {
        var bsfppc_publish_flag = 0;
        var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
        var $bsfppc_checkboxes_length = $('#checkbox[type="checkbox"]').length;
        
             
           
        var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
       
        // if($('#publish').length==1){
        //      if ($bsfppc_checkboxes_length != countCheckedbsfppc_checkboxes) {
                               
        //                         console.log('start');
        //                          var bsfppc_prevent = function(e) {
        //                             e.preventDefault();
        //                             e.stopPropagation();
        //                          }
        //                           $('#publish').bind('click', bsfppc_prevent);

        //                     }
        // }else{
        //     if ($bsfppc_checkboxes_length == countCheckedbsfppc_checkboxes) {

        //                         $('#publish').unbind('click', bsfppc_prevent);

        //                     }
        // }                    
        $bsfppc_checkboxes.on(
            'change',
            function() {

                if ($(this).prop("checked") == true) {
                    var bsfppc_post_id = $("#post_ID").val()
                    $.post(
                        bsfppc_meta_box_obj.url, {
                            action: 'bsfppc_ajax_add_change',
                            bsfppc_field_value: $(this).attr('value'),
                            bsfppc_post_id: bsfppc_post_id
                        },
                        function(data) {
                            if (data === 'sucess') {

                            } else if (data === 'failure') {

                            } else {

                            }
                        }
                    );
                } else if ($(this).prop("checked") == false) {

                    var bsfppc_post_id = $("#post_ID").val()
                    $.post(
                        bsfppc_meta_box_obj.url, {
                            action: 'bsfppc_ajax_delete_change',
                            bsfppc_field_value: $(this).attr('value'),
                            bsfppc_post_id: bsfppc_post_id
                        },
                        function(data) {
                            if (data === 'sucess') {

                            } else if (data === 'failure') {

                            } else {

                            }
                        }
                    );
                }
            }
        );
    if($('#publish').length !== 1){
                setTimeout(

                    function() {

                        if (bsfppc_radio_obj.option != 3 && ($bsfppc_checkboxes_length != countCheckedbsfppc_checkboxes)) {


                            if ($('.editor-post-publish-panel__toggle').length == 1) {
                                $('.editor-post-publish-panel__toggle').attr('style', 'display:none');

                            } else if ($('.editor-post-publish-button').length == 1) {


                                $('.editor-post-publish-button').attr('style', 'display:none');

                            }
                            if ($('.edit-post-header__settings').children('.editor-post-save-draft').length != 0) {

                                $('.edit-post-header__settings').children(':eq(1)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-publish">Publish...</button>');
                            } else if ($('.edit-post-header__settings').children('.editor-post-switch-to-draft').length == 1) {


                                $('.edit-post-header__settings').children(':eq(1)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-update">Update</button>');
                            } else if ($('.edit-post-header__settings').children('.editor-post-switch-to-draft').length == 0) {


                                $('.edit-post-header__settings').children(':eq(1)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-publish">Publish...</button>');
                            }

                        }
                    }, 10
                );

                if (bsfppc_radio_obj.option == 1 || bsfppc_radio_obj.option == 2) {
                    $bsfppc_checkboxes.change(
                        function() {

                            var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
                            var $bsfppc_checkboxes_length = $('#checkbox[type="checkbox"]').length;
                            var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
                            if ($bsfppc_checkboxes_length == countCheckedbsfppc_checkboxes) {


                                if ($('.editor-post-publish-panel__toggle').length == 1) {


                                    $('.edit-post-header__settings').children($('#bsfppc-publish').attr('style', 'display:none'));
                                    $('.editor-post-publish-panel__toggle').attr('style', 'display:inline-flex');

                                } else if ($('.editor-post-publish-button').length == 1) {


                                    $('.edit-post-header__settings').children(':eq(2)').after($('#bsfppc-update').attr('style', 'display:none'));
                                    $('.editor-post-publish-button').attr('style', 'display:inline-flex');

                                }

                            } else if ($bsfppc_checkboxes_length != countCheckedbsfppc_checkboxes) {

                                if ($('.editor-post-publish-panel__toggle').length == 1) {

                                    $('.editor-post-publish-panel__toggle').attr('style', 'display:none');

                                    $('.edit-post-header__settings').children(':eq(2)').after($('#bsfppc-publish').attr('style', 'display:inline-flex'));
                                    if ($('#bsfppc-publish').length == 0) {

                                        $('.edit-post-header__settings').children(':eq(2)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-publish">Publish...</button>');
                                    }

                                } else if ($('.editor-post-publish-button').length == 1) {

                                    $('.editor-post-publish-button').attr('style', 'display:none');

                                    $('.edit-post-header__settings').children(':eq(2)').after($('#bsfppc-update').attr('style', 'display:inline-flex'));
                                    if ($('#bsfppc-update').length == 0) {

                                        $('.edit-post-header__settings').children(':eq(2)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-update">Update</button>');
                                    }




                                }
                            }
                        });
                }
                //Do nothing--------------
                else if (bsfppc_radio_obj.option == 3) {
                    var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
                    var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
                    $bsfppc_checkboxes.change(
                        function() {
                            var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
                            if ($bsfppc_checkboxes.length == countCheckedbsfppc_checkboxes) {

                                $('.dashicons-warning').hide();
                                if ($('.editor-post-publish-panel__toggle').length == 1) {
                                    $('.editor-post-publish-panel__toggle').prop('title', 'All items checked ! You are good to publish');

                                } else if ($('.editor-post-publish-button').length == 1) {
                                    $('.editor-post-publish-button').prop('title', 'All items checked ! You are good to publish');

                                }
                            } else if ($bsfppc_checkboxes.length != countCheckedbsfppc_checkboxes) {
                                // all bsfppc_checkboxes are not yet checked 
                                $('.dashicons-warning').show();
                                if ($('.editor-post-publish-panel__toggle').length == 1) {
                                    $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist some items still remaining ');
                                } else if ($('.editor-post-publish-button').length == 1) {
                                    $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist some items still remaining !');
                                }
                            }
                        }

                    );
                }

            }else{
                   $(document).on('click', "#publish", function(e) {
                    var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
                    var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
                    console.log($bsfppc_checkboxes.length);
                    console.log(countCheckedbsfppc_checkboxes);

                    if ($bsfppc_checkboxes.length == countCheckedbsfppc_checkboxes){
                        return true;
                    }
                    else{
                           if(bsfppc_publish_flag == 0){
                            console.log('in flag 0');
                                if (bsfppc_radio_obj.option == 2 ) {
                                    console.log('in rdaio option 2 flag 0');
                                    $('.bsfppc-modal-warn').attr('style', 'display:block');
                                }
                                else if(bsfppc_radio_obj.option == 1){
                                     console.log('in rdaio option 1  flag 0');
                                     $('.bsfppc-modal-prevent').attr('style', 'display:block');
                                }
                                return false;
                            }else if(bsfppc_publish_flag == 1){
                                console.log('publish holya pahije');
                                bsfppc_publish_flag == 0;
                                return true;
                            }
                    }

                 });
            }


                    if (bsfppc_radio_obj.option == 2) {

                    $(document).on('click', "#bsfppc-update", function() {


                        $('.bsfppc-modal-warn').attr('style', 'display:block');

                    });

                    $(document).on('click', "#bsfppc-publish", function() {
                        console.log('hi');
                        // console.log(' warn clicked publish  user option');
                        $('.bsfppc-modal-warn').attr('style', 'display:block');


                    });


                } else if (bsfppc_radio_obj.option == 1) {

                    $(document).on('click', "#bsfppc-update", function() {

                        $('.bsfppc-modal-prevent').attr('style', 'display:inline-block');

                    });


                    $(document).on('click', "#bsfppc-publish", function() {

                        $('.bsfppc-modal-prevent').attr('style', 'display:block');

                        var content = $("#bsfppc_custom_meta_box").html();


                    });

                }

                $(document).on('click', ".bsfppc-popup-options-publishanyway", function() {
                
                    $('.bsfppc-modal-warn').attr('style', 'display:none');
                    if ($('.editor-post-publish-panel__toggle').length == 1) {

                        $('.edit-post-header__settings').children($('#bsfppc-publish').attr('style', 'display:none'));
                        $('.editor-post-publish-panel__toggle').attr('style', 'display:inline-flex');
                        $('.editor-post-publish-panel__toggle').trigger('click', 'publish');

                    } else if ($('.editor-post-publish-button').length == 1) {


                        $('.edit-post-header__settings').children(':eq(2)').after($('#bsfppc-update').attr('style', 'display:none'));
                        $('.editor-post-publish-button').attr('style', 'display:inline-flex');
                        $('.editor-post-publish-button').trigger('click', 'update');

                    }else {
                        console.log('its the condition');
                        bsfppc_publish_flag = 1;
                        $('.bsfppc-modal-warn').attr('style', 'display:none');
                        $('#publish').trigger('click', 'publish');
                    }


                });
                $(document).on('click', ".bsfppc-popup-option-dontpublish", function() {

                     if( $('#bsfppc_custom_meta_box').attr("class") == 'postbox closed' ){
                        $('#bsfppc_custom_meta_box').attr('class','postbox');
                    }

                    $('.bsfppc-modal-warn').attr('style', 'display:none');
                    document.querySelector('#bsfppc_custom_meta_box').scrollIntoView({
                        behavior: 'smooth'
                    });
                    
                        
                        $('#bsfppc_custom_meta_box').fadeOut(1500 ,  function(){
                            $(this).attr('style','background-color:#f2fff9');
                            $(this).fadeIn( 1500 , function(){
                                $(this).attr('style','background-color:#f2fff9');
                            });
                        });
                    
                    
                    jQuery('#bsfppc_custom_meta_box').focus();
                });

                $(document).on('click', ".bsfppc-popup-option-okay", function() {
                    if( $('#bsfppc_custom_meta_box').attr("class") == 'postbox closed' ){
                        $('#bsfppc_custom_meta_box').attr('class','postbox');
                    }
                    $('.bsfppc-modal-prevent').attr('style', 'display:none');
                    document.querySelector('#bsfppc_custom_meta_box').scrollIntoView({
                        behavior: 'smooth'
                    });
                    $('#bsfppc_custom_meta_box').animate( {backgroundColor: 'red'} , 1000);
                    $('#bsfppc_custom_meta_box').animate( {backgroundColor: '#fff'} , 1000);

                });
    }

);