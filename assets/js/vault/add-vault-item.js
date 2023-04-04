
jQuery(document).ready(function() {

  const loginComponent = `<div class="mb-4" id="login-username">
                              <label for="user_name" class="block text-md font-semibold text-gray-900 capitalize">User Name</label>
                              <input type="text" id="user_name" name="user_name" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="User name goes here..." />
                            </div>
                            <div class="mb-4" id="login-email">
                              <label for="email" class="block text-md font-semibold text-gray-900 capitalize">Email</label>
                              <input type="email" id="email" name="email" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="example@something.com"/>
                            </div>

                            <div class="mb-4" id="login-password" style="display: none;">
                              <label for="password" class="block text-md font-semibold text-gray-900 capitalize">Password</label>
                              <input autocomplete="password" type="password" id="password" name="password" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Password goes here..." />
                            </div>

                            <div class="mb-4" id="login-url">
                              <label for="url" class="block text-md font-semibold text-gray-900 capitalize">URL</label>
                              <input type="url" id="url" name="url" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="ex. https://google.com"/>
                            </div>`;

    const cardComponent = `<div class="mb-4" id="card-card-holder-name">
                              <label for="card_holder_name" class="block text-md font-semibold text-gray-900 capitalize">Card Holder Name</label>
                              <input v-model="vaultData.card_holder_name" type="text" id="card_holder_name" name="card_holder_name" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Card holder name goes here..." />
                            </div>
                            <div class="mb-4" id="card-card-number">
                              <label for="card_number" class="block text-md font-semibold text-gray-900 capitalize">Card Number</label>
                              <input v-model="vaultData.card_number" type="number" id="card_number" name="card_number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Card Number goes here..."/>
                            </div>
                            <div class="mb-4" id="card-card-expiration-date">
                              <label for="card_expiration_date" class="block text-md font-semibold text-gray-900 capitalize">Expiration Date</label>
                              <input v-model="vaultData.card_expiration_date" type="date" id="card_expiration_date" name="card_expiration_date" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Expiration date goes here..." />
                            </div>
                            <div class="mb-4" id="card-card-securiy-code">
                              <label for="card_security_code" class="block text-md font-semibold text-gray-900 capitalize">Security Code</label>
                              <input v-model="vaultData.card_security_code" type="text" id="card_security_code" name="card_security_code" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Securite code goes here..." />
                            </div>`;

  // closeing the modal
  jQuery('#close-add-item-modal').click(function(){
    jQuery('#add-menu-item-modal').hide();
  });
  // getting category and adding form element
    var selectedValue = jQuery('#category').val();
    if(selectedValue == 'Login'){
      jQuery("#name-div").after(loginComponent);;
    }


    // get folder
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
      }
    });

    // adding form element 
    jQuery('#category').on('change', function() {
      selectedValue = jQuery(this).val();
      console.log(selectedValue);

      switch (selectedValue) {
        case 'Login':
          jQuery("#name-div").nextUntil("#note-div").remove();
          jQuery("#name-div").after(loginComponent);
          break;
        
        case 'Card':
          jQuery("#name-div").nextUntil("#note-div").remove();
          jQuery("#name-div").after(cardComponent);
          break;
        
        case 'Secure note':
          jQuery("#name-div").nextUntil("#note-div").remove();
        default:
          break;
      }
    });


    jQuery('#create-vault').submit(function(e) {
      
      // prevent the form from submitting via the browser
      e.preventDefault(); 
      
      // serialize the form data
      var formData = jQuery(this).serialize(); 
      jQuery.ajax({
        url: window.fp_plugin_data.rest_url + '/create-vault',
        data: formData,
        type: "POST",
        success: function(data) {
            jQuery('#add-menu-item-modal').hide();
            location.reload(true);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
      });
    });

});