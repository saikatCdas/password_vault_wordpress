jQuery(document).ready(function() {

    // getting element from database
    // jQuery(document).load(function(){
    //     vaultItems({category:'all'});
    // })
    getVaultItems({category:'all', });


    // make post request
    jQuery.ajax({
      url: "http://wordpress.test/wp-json/fluentplugin/v2/get-folder", 
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        var folderNameContainer = [];
  
        jQuery.each(response, function(index, folder) {
            // pushing folder name button in an array
            folderNameContainer.push(folderName(folder.name));
        });
        // adding them into div
        jQuery('#button-container').prepend(folderNameContainer);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus + ': ' + errorThrown);
      }
    }).then(()=>{
        jQuery('#button-container').find("button").on('click', function(){

            // removing class from buttons
            jQuery('#button-container').find("button").removeClass("text-blue-600");
            jQuery('.category').removeClass("text-blue-600");

            // adding class to the current button
            jQuery(this).addClass("text-blue-600");

            // getting the innertext of the button
            var selectedValue = jQuery(this).find('span').text();

            // getting the vaule
            getVaultItems({folderName: selectedValue });
            
        })
    });

    jQuery('.category').on('click', function(){
        // getting the innertext of the button
        selectedValue = jQuery(this).text();

        // removing class from buttons
        jQuery('#button-container').find("button").removeClass("text-blue-600");
        jQuery('.category').removeClass("text-blue-600");

        // adding class to the current button
        jQuery(this).addClass("text-blue-600");

        getVaultItems({category: selectedValue });
    })
  });

  
  

  // adding folder name into button
  function folderName(name){
    return `<button id="folder-button" type="button" class="py-1 px-4 flex items-center justify-start space-x-1 hover:text-blue-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                <span>`+ name +`</span>
            </svg>
        </button>`;
  }


