
  jQuery('#import-button').click( function(event) {
    event.preventDefault(); // Prevent the form from submitting normally
    // Get the file input element
    console.log('hald;flj;adj;f');
    var fileInput = jQuery('input[name="import_file"]')[0];
    
    // Get the selected file
    var file = fileInput.files[0];
    let extensionNotMatch = checkingFileExtension(file.name)
    if(extensionNotMatch){
        return;
    }
    
    // Create a FormData object to send the file
    var formData = new FormData();
    formData.append('import_file', file);

    // append action
    // formData.append('action', 'fp_import_vault');

    // sending the ajax request to the backend using action
    jQuery.ajax({
      url: window.fp_plugin_data.rest_url + '/import',
      type: "POST",
      dataType: "json",
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
          jQuery('#csv-file-input').val(''); 
          notificationView('success', 'Data imported successfully!!!');         ;
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
          notificationView('error', 'Something is wrong!!!');
      }
    });
   

    return false; // Prevent the form from submitting normally
  });

  function checkingFileExtension(file){
    const fileExtension = file.split('.');
    if(fileExtension[fileExtension.length - 1].toLowerCase() !== 'csv'){
        return true;
    }
  }
