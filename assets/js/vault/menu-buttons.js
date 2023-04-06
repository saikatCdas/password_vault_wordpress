
jQuery(document).ready(function(){
    var menuHoverButton = jQuery('#mouser-hover-button');
    var menuButtonDiv = jQuery('#menu-button-hoder-div');

    // hiding menu buttons
    menuButtonDiv.hide();
 

    // on hover button showing menubuttons
    menuHoverButton.on('mouseenter', function() {
        menuButtonDiv.show();
    });

    // making the button hide if it leaves menudiv or the hover button
    menuHoverButton.on('mouseleave', function() {

        var mouseInsideMenuButtonDiv = false;

        // cheecking if the mouse is on menubutton div
        menuButtonDiv.on('mouseenter', function() {
            mouseInsideMenuButtonDiv = true;
          });
          // if not the hiding the menu button div
        setTimeout(function() {
            if(!mouseInsideMenuButtonDiv){
                menuButtonDiv.hide();
            }
        }, 200);
    });

  
    //show if mouse is on menubutton div
    menuButtonDiv.on('mouseenter', function() {
        menuButtonDiv.show();
    });

     // hiding menu button div if it leave the div
     menuButtonDiv.on('mouseleave', function() {
        menuButtonDiv.hide();
    });

    //  // Deleteing selected items
    jQuery('#delete-selected-items').click(function(){
        jQuery.ajax({
          url: window.fp_plugin_data.rest_url + '/delete-selected-vault-item/' + itemsId,  
          type: 'DELETE',
          dataType: 'json',
          data: {ids : itemsId},
          success: function(response) {
            jQuery.each(itemsId, function(index, id) {
              // jQuery(`#${id}`).closest('div').remove();
              jQuery(`.${id}`).remove();
            });
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error(textStatus + ': ' + errorThrown);
          }
      })
      });

      //moving selected item
      jQuery('#move-selected-items').click(function(){
        jQuery('#folder-modal').show();
        jQuery('#create-folder-name').hide();
        jQuery('#create-folder-name').prop('required', false);
        jQuery('#show-folder-name').show();
        jQuery('#folder-modal-header').text('Change Folder');
        jQuery('#folder-modal-sumbit-button').text('Change');
        jQuery('#folder-name-select').find('option').not('#option-no-folder').remove();
        // get folder name form folder 
        jQuery.ajax({
          url: window.fp_plugin_data.ajax_url, 
          type: 'GET',
          dataType: 'json',
          data: {
            action: 'fp_get_folder_items'
          },
          success: function(response) {
            jQuery.each(response, function(index, folder) {
              let option = `<option id="`+ folder.id +`" value="`+ folder.id +`">`+ folder.name +`</option>`
              jQuery(option).insertBefore('#option-no-folder');
            });
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus + ': ' + errorThrown);
          }
        })
      })

      // selecting all items
      jQuery('#selecting-all-items').click(function(){
        itemsId = [];
        jQuery('.item-checkbox').each(function(){
          jQuery(this).prop('checked', true);
          itemsId.push(jQuery(this).val());
        })
      })

      // unselecting all items
      jQuery('#unselect-all-items').click(function(){
        jQuery.each(itemsId, function(index, id) {
          jQuery(`#${id}`).prop('checked', false);
        });
        itemsId = [];
      })
});
