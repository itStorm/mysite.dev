$( document ).ready(function() {
    tinymce.init({
        selector: ".wisywyg-editor",
        plugins: "image, link, media, emoticons, code, imagetools, textcolor, table, pagebreak, contextmenu, fullscreen",
        toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor emoticons",
        file_picker_callback : elFinderBrowser
    });
});

function elFinderBrowser (callback, value, meta) {
    tinymce.activeEditor.windowManager.open({
        file: '/file',// use an absolute path!
        title: 'elFinder 2.0',
        width: 900,
        height: 450,
        resizable: 'yes'
    }, {
        oninsert: function (file, elf) {
            var url, reg, info;

            // URL normalization
            url = file.url;
            reg = /\/[^/]+?\/\.\.\//;
            while(url.match(reg)) {
                url = url.replace(reg, '/');
            }

            // Make file info
            info = file.name + ' (' + elf.formatSize(file.size) + ')';

            // Provide file and text for the link dialog
            if (meta.filetype == 'file') {
                callback(url, {text: info, title: info});
            }

            // Provide image and alt text for the image dialog
            if (meta.filetype == 'image') {
                callback(url, {alt: info});
            }

            // Provide alternative source and posted for the media dialog
            if (meta.filetype == 'media') {
                callback(url);
            }
        }
    });
    return false;
}