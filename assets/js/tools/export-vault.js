jQuery('#exportButton').click(function () {
      jQuery.ajax({
        url: window.fp_plugin_data.ajax_url,
        type: "POST",
        dataType: "json",
        data: {
        action: "fp_export_vault",
        },
        success: function(response) {
          // console.log();
          // return
          // returning if the vault has no items
          if( Object.keys(response).length === 0){
            notificationView('error', 'No item found in database!!!');;
            return;
          }
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
          link.click().then(()=>{
            notificationView('success', 'Data exported successfully!!!');
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
        notificationView('error', 'Something is wrong!!!');
        }
    });

  });

