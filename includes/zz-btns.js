tinymce.PluginManager.add('zz_tc_simple', function( editor, url ) {
    editor.addButton( 'zz_tc_simple', {
        text: 'Simple',
        onclick: function() {
            editor.insertContent('Just some simple text');
        }
    });
});
