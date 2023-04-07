// initial items id for selecting and unselecting item
var itemsId = [];

jQuery(document).ready(function() {
  
  
  // open add vault modal 
  jQuery('#add-item-modal-button').click(function(){
    jQuery('#manage-vault-header-name').text('Add Item');
    jQuery('#manage-vault-submit-button').text('Create Item');
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


  // open the folder modal to create folder 
  jQuery('#open-folder-modal').click(function(){
    jQuery('#show-folder-name').hide();
    jQuery('#folder-modal').show();
    jQuery('#create-folder-name').show();
    jQuery('#create-folder-name').prop('required', true);
    jQuery('#folder-modal-header').text('Create Folder');
    jQuery('#folder-modal-sumbit-button').text('Create');
  })

  // create folder in database
  jQuery('#folder-name-modal').submit(function(e){
    // preventing default
    e.preventDefault();

    // serilalize form data
    // var formData = jQuery('#folder-name-modal').serialize(); 
    
    // var f
    let method ;
    let formData; 
    let selectSubmitButton = jQuery('#folder-modal-sumbit-button').text();

    // giving rule for update or create
    switch(selectSubmitButton){
      case 'Create':
        formData = {name : jQuery('#folder-name').val()};
        method = 'POST';
        url = '/create-folder'
        break;

      case 'Change':
        formData = {
          folderId: jQuery('#folder-name-select').val(),
          itemsId
        };
        method = 'PUT';
        url = '/move-folder'
        break;

      default:
        return;
    }
    // send post rerquest to create folder 
    jQuery.ajax({
      url: window.fp_plugin_data.rest_url + url,
      data: formData,
      type: method,
      success: function(response) {
        jQuery('#folder-modal').hide();
        if(selectSubmitButton === "Create"){
          jQuery(folderName(response.name)).insertBefore('.no-folder-button');
          notificationView('success', 'Folder created successfully!!!');
        } else{
          jQuery.each(itemsId, function(index, id) {
            // jQuery(`#${id}`).closest('div').remove();
            jQuery(`.${id}`).remove();
          });
          notificationView('success', 'Moved successfully!!!');
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
          jQuery('#folder-modal').hide();
          notificationView('error', 'Something went wrong!!!');
      }

    }).then(()=>{
      getItemByFolder();
    })
  })

  // close the folder modal 
  jQuery('#close-folder-modal').click(function(){
    // jQuery('#folder-name-select').find('option').not('#option-no-folder').remove();
    jQuery('#folder-modal').hide();
  })

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
      getItemByFolder();
    });


    // getting element by folder
    function getItemByFolder(){
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
    }
    // getting element by category
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
    function getVaultItems(type, url = null){
      itemsId= [];
      let queryString;

      url = url || window.fp_plugin_data.ajax_url;
      queryString = Object.keys(type).map(key => key + '=' + type[key]).join('&');
      const encodedData = encodeURIComponent(JSON.stringify(queryString));

      jQuery.ajax({
          url: url,  
          // url: '/wp-json/fluentplugin/v2/search?page=2',
          type: 'GET',
          dataType: 'json',
          data: {
            encodedData,
            action: 'fp_get_vault_items'
          },
          success: function(response) {
            if(response.next_page_url || response.prev_page_url){
              pagination(type, response, getVaultItems);
            }
            showVaultItemsOnFront(response.data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error(textStatus + ': ' + errorThrown);
              notificationView('error', 'Something is wrong!!!');
          }
      }).then(()=>{

        // get selected elements id
        
        jQuery('.item-checkbox').on('change', function(){
          let isChecked = jQuery(this).is(':checked');
          if(isChecked){
            itemsId.push(jQuery(this).val());
          } else{
            let indexOfUncheckdValue = itemsId.indexOf(jQuery(this).val())
            itemsId.splice(indexOfUncheckdValue, 1);
          } 
        });

        // editing item
        jQuery('.edit-vault-item-button').click(function(){
          jQuery.ajax({
            url: window.fp_plugin_data.ajax_url, 
            type: 'GET',
            dataType: 'json',
            data: {
              action: 'fp_get_folder_items'
            },
            success: function(response) {
              var folderSelect = jQuery('#folder');
              jQuery.each(response, function(index, folder) {
                folderSelect.append('<option value="' + folder.name + '">' + folder.name + '</option>');
              });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.error(textStatus + ': ' + errorThrown);
              notificationView('error', 'Something is wrong!!!');
            }
          });
          editVautlItem(jQuery(this).attr('id'));
        })

        
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
            jQuery('#vault-items-show-div').append(vaultItemShow(item));
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


    // search item 
    let timeout = null;
    jQuery('#search-form').find('#search').on( 'input', function (e){
      e.preventDefault();
      let searchInp = jQuery(this).val();
      clearTimeout(timeout);
      timeout = setTimeout(function () {
          search({searchInp: searchInp})
      }, 1000);
    });

    // search in database
    function search(data, url = null){
        url = url || window.fp_plugin_data.rest_url + '/search';
        jQuery.ajax({
            url: url,  
            type: 'GET',
            dataType: 'json',
            data: data,
            success: function(response) {
              if(response.next_page_url || response.prev_page_url){
                pagination(data, response, search);
              }
              showVaultItemsOnFront(response.data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus + ': ' + errorThrown);
                notificationView('error', 'Something is wrong!!!');
            }
        })
    }

    jQuery('#search-form').on('submit', function (e){
      e.preventDefault();
    });

    // Edit Vault Item
    function editVautlItem(id){
      jQuery.ajax({
        url: window.fp_plugin_data.rest_url + '/get-item',  
        type: 'GET',
        dataType: 'json',
        data: {id:id},
        success: function(response) {
          showItemInEditForm(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus + ': ' + errorThrown);
            notificationView('error', 'Something is wrong!!!');
        }
    })
    }
    

    // show item in edit form 
    function showItemInEditForm(item){
      jQuery('#manage-vault-header-name').text('Edit Item');
      jQuery('#manage-vault-submit-button').text('Update');
      jQuery('#manage-vault #category').val(item.category);
      jQuery('#manage-vault #folder').val(item.folder);
      jQuery('#manage-vault #name').val(item.name);
      jQuery('#manage-vault #user_name').val(item.user_name);
      jQuery('#manage-vault #email').val(item.email);
      jQuery('#manage-vault #password').val(item.password);
      jQuery('#manage-vault #url').val(item.url);
      jQuery('#manage-vault #card_holder_name').val(item.card_holder_name);
      jQuery('#manage-vault #card_number').val(item.card_number);
      jQuery('#manage-vault #card_expiration_date').val(item.card_expiration_date);
      jQuery('#manage-vault #card_security_code').val(item.card_security_code);
      jQuery('#manage-vault #notes').val(item.notes);
      jQuery('#manage-vault #user_id').val(item.user_id);
      jQuery('#manage-vault #id').val(item.id);
      switch (item.category) {
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


      jQuery('#add-menu-item-modal').show();
    }

    function pagination(data, response, pageItems){
      jQuery('#pagination-div').show();
      jQuery('#pagination-div').addClass('!flex');
      jQuery('#pagination-nav').empty();
      var url = response.next_page_url !== null ? response.next_page_url : response.prev_page_url
      var newUrl = url.replace(/\?page=\d+|&page=\d+/g, '?page=');
      var totalPage = response.last_page;
      // console.log(totalPage);
      for (let i = 1; i <= totalPage; i++) {
        jQuery('#pagination-nav').append(
          `<button 
              type="button"
              value="`+newUrl+i+`"
              id="page-number-`+i+`"
              class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap bg-white border-gray-300 text-gray-500 hover:bg-gray-50 rounded-l-md rounded-r-md bg-gray-100 text-gray-700"
              >
              `+i+`
          </a>`
        )
      }
      jQuery(`#page-number-${response.current_page}`).addClass('z-10 bg-indigo-50 border-indigo-500 text-indigo-600')
      
      jQuery('#pagination-nav button').click(function() {
        if(jQuery(this).attr('id') === `page-number-${response.current_page}`){
          console.log('hello world');
          return;
        }
        pageItems(data ,jQuery(this).attr('value'))
      });
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
      return`<div class="flex items-center space-x-5 text-gray-500 pl-5 py-3 `+ item.id +`">
      <input type="checkbox" class="item-checkbox" id=`+ item.id +` name="` +item.id +`" class="rounded w-[16px] h-[16px]" value="` + item.id +`">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-xs">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 01-5.276 3.67m0 0a9 9 0 01-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
      </svg>
      <button type="button" id=`+ item.id +` class="text-sky-600 hover:text-sky-700 hover:underline cursor-pointer edit-vault-item-button">` + item.name + `</button>
  </div>
  <hr class="`+ item.id +`">`;
    }

  });

  
  
  

  


