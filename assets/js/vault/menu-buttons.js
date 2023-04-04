
jQuery(document).ready(function(){
    var menuHoverButton = jQuery('#mouser-hover-button');
    var menuButtonDiv = jQuery('#menu-button-hoder-div');

    // hiding menu buttons
    menuButtonDiv.hide();
 

    // on hover button showing menubuttons
    menuHoverButton.on('mouseenter', function() {
        menuButtonDiv.show();
    });

    // making the button hide if it leaves menudiv or the hover button
    menuHoverButton.on('mouseleave', function() {

        var mouseInsideMenuButtonDiv = false;

        // cheecking if the mouse is on menubutton div
        menuButtonDiv.on('mouseenter', function() {
            mouseInsideMenuButtonDiv = true;
          });
          // if not the hiding the menu button div
        setTimeout(function() {
            if(!mouseInsideMenuButtonDiv){
                menuButtonDiv.hide();
            }
        }, 200);
    });

  
    //show if mouse is on menubutton div
    menuButtonDiv.on('mouseenter', function() {
        menuButtonDiv.show();
    });

     // hiding menu button div if it leave the div
     menuButtonDiv.on('mouseleave', function() {
        menuButtonDiv.hide();
    });
});
