(function() {
    tinymce.create('tinymce.plugins.ctfsnippet', {

        init : function(editor, url) {
          editor.addButton( 'ctfaddblock', {
            title: 'Add CTF Block',
            cmd:   'ctfaddblock',
            image: url + '/tinymce_button.png'
          });
          
          // Called when we click the button
          editor.addCommand( 'ctfaddblock', function() {
            // Calls the pop-up modal
            editor.windowManager.open({
              // Modal settings
              title: 'Insert CTF Snippet',
              width: jQuery( window ).width() * 0.4,
              // minus head and foot of dialog box
              height: (jQuery( window ).height() - 36 - 50) * 0.3,
              inline: 1,
              id: 'plugin-slug-insert-dialog',
              body: [
                {type: 'textbox', id: 'ctf_category', name: 'category', label: 'CTF/Category'},
                {type: 'textbox', id: 'ctf_link', name: 'link', label: 'Link to CTF'},
                {type: 'textbox', id: 'ctf_date', name: 'date', label: 'Date Completed'},
                {type: 'checkbox', id: 'ctf_dofollow', name: 'dofollow', label: 'Dofollow?'}
              ],
              buttons: [{
                text: 'Insert',
                id: 'plugin-slug-button-insert',
                class: 'insert',
                onclick: function(editor) {
                  //Fetch ID's of fields we want
                  category = document.getElementById('ctf_category').value;
                  link = document.getElementById('ctf_link').value;
                  date = document.getElementById('ctf_date').value;
                  dofollow = (document.getElementById('ctf_dofollow').getAttribute('aria-checked') == "true") ? 1 : 0;
                  
                  //Make shortcode string
                  shortcode = "[ctf-snippet category='" + category + "' link='" + link +
                              "' date='" + date + "' dofollow=" + dofollow + "]";
                  tinymce.activeEditor.execCommand('mceInsertContent', false, shortcode);
                  tinyMCE.activeEditor.windowManager.close();
                  
                },
              },
              {
                text: 'Cancel',
                id: 'plugin-slug-button-cancel',
                onclick: 'close'
              }],
            });

          });
          
        },
 
        createControl : function(n, cm) {
            return null;
        },
        
        getInfo : function() {
            return {
                longname : 'CTF Snippet Inserter',
                author : 'Mohammas Ghasembeigi',
                authorurl : 'https://mohammadg.com',
                version : "1.0"
            };
        }
    });

 
    // Register plugin
    tinymce.PluginManager.add( 'ctfsnippet', tinymce.plugins.ctfsnippet );
})();