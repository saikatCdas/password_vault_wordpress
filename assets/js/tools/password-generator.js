jQuery(document).ready(function(){

    

    
    // hide the passphrase generator;
    jQuery('#generator-type-passphrase').hide();

    // Generate a intital password
    let password = generatePassword();

    // hover the copy text 
    jQuery('#password-copy-text').hide();
    jQuery('.password-copy-button').hover(function(){
        jQuery('#password-copy-text').show();
    }, function(){
        jQuery('#password-copy-text').hide();
    });

    if(!(jQuery('#numbers').prop('checked'))){
        minNumericChars = 0;
        jQuery('#min-special-chars').prop('disabled', true);
        jQuery('#min-special-chars').val(0);
    } 

    // Attach change event to radio buttons
    jQuery('input[type=radio][name=password-generator]').change(function() {
        // Get selected value
        var selectedValue = jQuery('input[type=radio][name=password-generator]:checked').val();
        switch(selectedValue){
            case 'password':
                jQuery('#generator-type-passphrase').hide();
                jQuery('#generator-type-password').show();
                generatePassword();
                break;
            case 'passphrase':
                jQuery('#generator-type-password').hide();
                jQuery('#generator-type-passphrase').show();
                generatePassphrase();
                break;
        }
    });


    // disable some input field and seeting value on checkbox input
    jQuery('#checkbox-container input[type=checkbox]').change(function() {

        var id = jQuery(this).attr('id');

        switch(id){
            case 'numbers':
                if(!(jQuery('#numbers')).prop('checked')){
                    jQuery('#min-numeric-chars').val(0);
                    jQuery('#min-numeric-chars').prop('disabled', true);
                } else{
                    jQuery('#min-numeric-chars').prop('disabled', false);
                    jQuery('#min-numeric-chars').val(2);
                }
                break;
            
            case 'special-character':
                if(!(jQuery('#special-character')).prop('checked')){
                    jQuery('#min-special-chars').val(0);
                    jQuery('#min-special-chars').prop('disabled', true);
                } else{
                    jQuery('#min-special-chars').prop('disabled', false);
                    jQuery('#min-special-chars').val(2);
                }
        }
      });


    // Generate password
    jQuery('#password-regenerator-button').click(function(){
        if(jQuery('input[type=radio][name=password-generator]:checked').val() === 'password'){
            generatePassword();
        } else{
            generatePassphrase();
        }
    });


    // Generate Password
    function generatePassword() {
        let length = jQuery('#length').val();
        let minSpecialChars = jQuery('#min-special-chars').val();
        let capitalLetters = jQuery('#capital-letters').prop('checked');
        let smallLetters = jQuery('#small-letters').prop('checked');
        let minNumericChars = jQuery('#min-numeric-chars').val();

        // define the character sets to use
        var specialChars = "!#$%&*+-=?@^_";
        var upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var lowerChars = "abcdefghijklmnopqrstuvwxyz";
        var numericChars = "0123456789";

        var possiblePassword = "";

        // initialize the password variable
        var password = "";

        var lengthForLetters = parseInt(length) - (parseInt(minNumericChars) + parseInt(minSpecialChars));

        // if capitalLetters
        if(capitalLetters){
            possiblePassword += upperChars;
        }

        // if smallLetters
        if(smallLetters){
            possiblePassword += lowerChars;
        }

        // add the Lower and||or uppercase characters to the password
        for (var i = 0; i < lengthForLetters; i++) {
            password += possiblePassword.charAt(Math.floor(Math.random() * possiblePassword.length));
        }

        // add the specified number of special characters to the password
        for (var i = 0; i < minSpecialChars; i++) {
            password += specialChars.charAt(Math.floor(Math.random() * specialChars.length));
        }

        // add the specified number of numeric characters to the password
        for (var i = 0; i < minNumericChars; i++) {
            password += numericChars.charAt(Math.floor(Math.random() * numericChars.length));
        }

        // shuffle the password
        password = shuffleString(password);

        // truncate the password if it's too long
        if (password.length > length) {
            password = password.substring(0, length);
        }

        // showing the password in frontend
        jQuery('#show-generator-password').text(password);
        // return the generated password
        return password;
    }

    // shuffle the characters in a string
    function shuffleString(str) {
        var arr = str.split("");
        var shuffledArr = arr.map((a) => [Math.random(), a]).sort((a, b) => a[0] - b[0]).map((a) => a[1]);
        return shuffledArr.join("");
    }

    // Generate Passphrase
    function generatePassphrase() {

        let capitalize = jQuery('#capitalize').prop('checked');
        let includeNumber = jQuery('#include-number').prop('checked');
        let wordSeparator = jQuery('#word-separator').val();
        let numWords = jQuery('#num-words').val();
        // array of words to use for passphrase
        let words = [ "there", "many", "variations", "passages", "lorem", "ipsum", "available", "majority", "have", "suffered", "alteration", "some", "form", "injected", "humour", "randomised", "words", "which", "dont", "look", "even", "slightly", "believable", "going", "passage", "lorem", "ipsum", "need", "sure", "there", "isnt", "anything", "embarrassing", "hidden", "middle", "text", "lorem", "ipsum", "generators", "internet", "tend", "repeat", "predefined", "chunks", "necessary", "making", "this", "first", "true", "generator", "internet", "uses", "dictionary", "over", "latin", "words", "combined", "with", "handful", "model", "sentence", "structures", "generate", "lorem", "ipsum", "which", "looks", "reasonable", "generated", "lorem", "ipsum", "therefore", "always", "free", "from", "repetition", "injected", "humour", "noncharacteristic", "words" ];
      
        // randomly select words for passphrase
        let passphrase = "";
        for (let i = 0; i < numWords; i++) {
          let randomIndex = Math.floor(Math.random() * words.length);
          let word = words[randomIndex];
          if (capitalize) {
            word = word.charAt(0).toUpperCase() + word.slice(1);
          }
          passphrase += word;
          if (i < numWords - 1) {
            passphrase += wordSeparator;
          }
        }
      
        if (includeNumber) {
          // generate a random number between 0 and 99
          let randomNumber = Math.floor(Math.random() * 100);
      
          // convert text to an array
          let textArray = passphrase.split("-");
      
          // choose a random word to insert number
          let randomIndex = Math.floor(Math.random() * textArray.length);
          textArray[randomIndex] = textArray[randomIndex] + randomNumber;
      
          passphrase = textArray.join("-");
        }
      
        // showing the password in frontend
        jQuery('#show-generator-password').text(passphrase);
        return passphrase;
      }
      

      // copy genrated password to the clipboard
      function copyToClipboard(text) {

        var textArea = document.createElement( "textarea" );
        textArea.value = text;
        document.body.appendChild( textArea );
     
        textArea.select();
     
        try {
           var successful = document.execCommand( 'copy' );
           var msg = successful ? 'successful' : 'unsuccessful';
           alert('Copying text command was ' + msg);
        } catch (err) {
           alert('Oops, unable to copy');
        }
     
        document.body.removeChild( textArea );
     }

     // copy password on clipboard on button click
     jQuery( '.copy-generator-password' ).click( function()
        {

            clipboardText = jQuery('#show-generator-password').text();

            copyToClipboard( clipboardText );
        });
})




