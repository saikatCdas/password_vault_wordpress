jQuery(document).ready( function () {
    const toolMenu = [ 'Generator', 'Imports', 'Exports' ];

    // fetchig tools component 
    const gettingToolsComponent = (type) => {
        jQuery.ajax({
            url: window.fp_plugin_data.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
            action: "tool_page_component",
            type: type
            },
            success: function(data) {
            // Append the class HTML to the container element
            jQuery('.php-class-container').html(data);

            if(type === 'Generator'){
                jQuery.getScript(window.fp_plugin_data.plugin_path + 'assets/js/tools/password-generator.js', function() {
                  });
            } else if(type === 'Exports'){
                jQuery.getScript(window.fp_plugin_data.plugin_path + 'assets/js/tools/export-vault.js', function() {
                  });
            } else if(type === 'Imports'){
                jQuery.getScript(window.fp_plugin_data.plugin_path + 'assets/js/tools/import-vault.js', function() {
                  });
            }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            }
        });
    }


    const addToolMenu = (toolmenuName) => {
        return `<div class="py-2 px-4 flex">
                    <button type="button" class=" text-gray-500 hover:text-blue-400">` + toolmenuName + `</button>
                </div>
                <hr>`;
    }

    jQuery.each(toolMenu, function( index, value ) {
        jQuery('#tool-menu-button').append(addToolMenu(value));
    });

    //// loading default class for page loaded
    jQuery('#tool-menu-button').find('button').each(function() {
        if((jQuery(this).text()== 'Generator' )){
            jQuery(this).removeClass('text-gray-500');
            jQuery(this).addClass('text-blue-700 text-lg font-medium');
            gettingToolsComponent(jQuery(this).text());
        }
      });

    // changing the class on button click
    jQuery('#tool-menu-button').find(':button').on('click', function(){
        jQuery('#tool-menu-button').find(':button').removeClass('text-blue-700 text-lg font-medium ');
        jQuery('#tool-menu-button').find(':button').addClass('text-gray-500');
        jQuery(this).removeClass('text-gray-500');
        jQuery(this).addClass('text-blue-700 text-lg font-medium');
        gettingToolsComponent(jQuery(this).text());
    })

        
    
})

