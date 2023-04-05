// var vaultItems = [];



jQuery(document).ready(function(){
    jQuery('#vaultItemName').text()
})


// // getting the item from baceknd;
// function getVaultItems(type){
//     let queryString;

//     queryString = Object.keys(type).map(key => key + '=' + type[key]).join('&');
//     const encodedData = encodeURIComponent(JSON.stringify(queryString));

//     jQuery.ajax({
//         url: `http://wordpress.test/wp-json/fluentplugin/v2/get-all-vault/${encodedData}`, 
//         type: 'GET',
//         dataType: 'json',
//         success: function(response) {
//           console.log(response.data);
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//             console.error(textStatus + ': ' + errorThrown);
//         }
//     });

//   }