
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
    
    // Send the AJAX request
    jQuery.ajax({
      url: "http://wordpress.test/wp-json/fluentplugin/v2/import",
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        console.log(response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
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
