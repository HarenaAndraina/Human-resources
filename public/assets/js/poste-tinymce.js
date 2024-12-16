document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const responsabilites = document.getElementById("poste_responsabilites");
    const exigences = document.getElementById("poste_exigences");

    if (responsabilites && exigences)
        tinymce.init({
            selector: '#poste_responsabilites, #poste_exigences',
            height: 200,
            menubar: false,
            plugins: 'image lists link anchor charmap',
            toolbar: 'blocks | bold italic bullist numlist | charmap',
            image_advtab: false,
            branding: false,
            contextmenu: false,
            content_css: ['data:text/css, body { font-size: 14px; }']
        });
});
