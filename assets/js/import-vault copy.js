jQuery(document).ready(function() {
 
  jQuery('#upload_csv_form').submit(function(event) {
    console.log('hello form import-vault');
    event.preventDefault(); // Prevent the form from submitting normally
    // Get the file input element
    var fileInput = jQuery('input[name="import_file"]')[0];
    console.log('hald;flj;adj;f')
    
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

  });

  function checkingFileExtension(file){
    const fileExtension = file.split('.');
    if(fileExtension[fileExtension.length - 1].toLowerCase() !== 'csv'){
        return true;
    }
  }
  
})