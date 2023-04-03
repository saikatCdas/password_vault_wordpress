jQuery('#exportButton').click(function () {
  jQuery.get("http://wordpress.test/wp-json/fluentplugin/v2/export",  function(response) {
      
          const header = Object.keys(response[0]).join(",");
          const data = response.map(obj => {
              return Object.values(obj).map(val => {
              if (typeof val === "string") {
                  return `"${val.replace(/"/g, '""')}"`;
              }
              return val;
              }).join(",");
          }).join("\n");

                          
          const blob = new Blob([`${header}\n${data}`], { type: "text/csv" });
          const url = URL.createObjectURL(blob);
          const link = document.createElement("a");
          link.setAttribute("href", url);
          link.setAttribute("download", "data.csv");
          link.click();
    })
    .done(function() {
      console.log('Request completed successfully.');
    })
    .fail(function() {
      console.log('Request failed.');
    });
  });







