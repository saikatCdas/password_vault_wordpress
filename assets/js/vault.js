jQuery(document).ready(function() {
  
  // open add vault modal 
  jQuery('#add-item-modal-button').click(function(){
    jQuery('#add-menu-item-modal').show();
  });

  // showing initial element
  function showInititalElement(){
    jQuery('#vault-request-progress').show();
    jQuery('#no-content-found-in-vault').hide();
    jQuery('#vault-items-show-div').hide();
  }
  
  // loading vault item on page load
  showInititalElement();
  // getting the initial vault items from database
  getVaultItems({category:'all', });

    // get folder name form folder 
    jQuery.ajax({
      url: window.fp_plugin_data.ajax_url, 
      type: 'GET',
      dataType: 'json',
      data: {
        action: 'fp_get_folder_items'
      },
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
            showInititalElement();
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
        showInititalElement();
        getVaultItems({category: selectedValue });
    })

    // getting the item from baceknd;
    function getVaultItems(type){
      let queryString;

      queryString = Object.keys(type).map(key => key + '=' + type[key]).join('&');
      const encodedData = encodeURIComponent(JSON.stringify(queryString));

      jQuery.ajax({
          url: window.fp_plugin_data.ajax_url,  
          type: 'GET',
          dataType: 'json',
          data: {
            encodedData,
            action: 'fp_get_vault_items'
          },
          success: function(response) {
            showVaultItemsOnFront(response.data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error(textStatus + ': ' + errorThrown);
          }
      });

    }

    // showing vault item in the frontend
    function showVaultItemsOnFront(items){
      if(items !== undefined) {
        if((Object.keys(items).length) !== 0){
          jQuery('#no-content-found-in-vault').hide()
          jQuery('#vault-items-show-div').show();
          jQuery('#vault-request-progress').hide();

          jQuery('#vault-items-show-div').empty();
          jQuery.each(items, function(index, item) {
            // adding items name button in an array
            jQuery('#vault-items-show-div').prepend(vaultItemShow(item));
        });
        } else{
          jQuery('#no-content-found-in-vault').show();
          jQuery('#vault-items-show-div').hide();
          jQuery('#vault-request-progress').hide();
        }
        
      } else{
        jQuery('#no-content-found-in-vault').show();
        jQuery('#vault-items-show-div').hide();
        jQuery('#vault-request-progress').hide();
      }
    }


    // adding folder name into button
    function folderName(name){
      return `<button id="folder-button" type="button" class="py-1 px-4 flex items-center justify-start space-x-1 hover:text-blue-300">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                  <span>`+ name +`</span>
              </svg>
          </button>`;
    }

    // adding vault item into container
    function vaultItemShow(item){
      return`<div class="flex items-center space-x-5 text-gray-500 pl-5 py-3">
      <input type="checkbox" name="` +item.id +`" class="rounded w-[16px] h-[16px]" value="` + item.id +`">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-xs">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 01-5.276 3.67m0 0a9 9 0 01-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
      </svg>
      <a href="#" class="text-sky-600 hover:text-sky-700 hover:underline cursor-pointer">` + item.name + `</a>
  </div>
  <hr>`;
    }
  });

  
  
  

  


