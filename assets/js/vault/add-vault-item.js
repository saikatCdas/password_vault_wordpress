
jQuery(document).ready(function() {
  // closeing the modal
  jQuery('#close-add-item-modal').click(function(){
    jQuery('#add-menu-item-modal').hide();
  });
  // getting category and adding form element
    var selectedValue = jQuery('#category').val();
    formComponent(selectedValue);


    // get folder information for add item form
    jQuery('#add-item-modal-button').click(function(){
      jQuery.ajax({
        url: window.fp_plugin_data.rest_url + '/get-folder', 
        type: 'GET',
        dataType: 'json',
        // data: {
        //   action: 'fp_get_folder_items'
        // },
        success: function(response) {
          var folderSelect = jQuery('#folder');
          folderSelect.find('option').not('#choose-a-foderl').remove();
          jQuery.each(response, function(index, folder) {
            folderSelect.append('<option value="' + folder.name + '">' + folder.name + '</option>');
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error(textStatus + ': ' + errorThrown);
          notificationView('error', 'Something is wrong!!!');
        }
      });
    });
    

    // adding form element 
    jQuery('#category').on('change', function() {
      selectedValue = jQuery(this).val();
      formComponent(selectedValue);
    });


    //rendering component vaule
    function formComponent(selectedValue){
      switch (selectedValue) {
        case 'Login':
          jQuery('.login-information-component').show();
          jQuery('.card-information-component').hide();
          break;
        
        case 'Card':
          jQuery('.login-information-component').hide();
          jQuery('.card-information-component').show();
          break;
        
        case 'Secure note':
          jQuery('.login-information-component').hide();
          jQuery('.card-information-component').hide();

        default:
          break;
      }
    }


    jQuery('#manage-vault').submit(function(e) {
      
      // prevent the form from submitting via the browser
      e.preventDefault(); 
      
      let method ;
      let url ;      
      // serialize the form data
      var formData = jQuery(this).serialize(); 
    
      if(jQuery('#manage-vault-submit-button').text() === 'Update'){
        method = "PUT",
        url = '/update-vault'
      } else{
        method = "POST",
        url = "/create-vault"
      }
      jQuery.ajax({
        url: window.fp_plugin_data.rest_url + url,
        data: formData,
        type: method,
        success: function(data) {
            jQuery('#add-menu-item-modal').hide();
            notificationView('success', 'Completed successfully!!!');
            setTimeout(()=>{
              location.reload(true);
            }, 500)
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            notificationView('error', 'Something is wrong!!!');
        }
      });
      
    });

});