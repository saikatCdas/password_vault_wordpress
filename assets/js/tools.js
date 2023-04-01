jQuery(document).ready( function () {
    const toolMenu = [ 'Generator', 'Imports', 'Exports' ];

    // fetchig tools component 
    const gettingToolsComponent = (type) => {
        jQuery.ajax({
            url: window.fp_plugin_data.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
            action: "my_ajax_action",
            type: type
            },
            success: function(data) {
            // Append the class HTML to the container element
            jQuery('.php-class-container').html(data);
            myMethod(type);
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

    function myMethod(type) {
        if(type == 'Exports'){
            console.log('hello world');
            wp_enqueue_script( 'my-script', '/Users/authlab/Documents/projects/wordpress/wp-content/plugins/FluentPlugin/assets/js/export-vault.js', array( 'jquery' ), '1.0', true );
        }
      }


    jQuery.each(toolMenu, function( index, value ) {
        jQuery('#tool-menu-button').append(addToolMenu(value));

        jQuery('#tool-menu-button').find('button').each(function() {
            // loading default class for page loaded
            if(jQuery(this).text()== 'Generator'){
                jQuery(this).removeClass('text-gray-500');
                jQuery(this).addClass('text-blue-700 text-lg font-medium');
                gettingToolsComponent(jQuery(this).text());
                
            }
          
          });
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


