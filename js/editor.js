(function (Drupal, once) {

  Drupal.behaviors.quillEditor = {
    attach(context) {

      once('quill-editor', 'textarea[name^="field_titles"][name$="[source]"], textarea[name^="field_descriptions"][name$="[source]"], textarea[name^="field_descriptions"][name$="[description]"]', context)
        .forEach((textarea) => {

          if (textarea.dataset.quillInitialized) {
            return;
          }
          textarea.dataset.quillInitialized = 'true';

          // Hide original textarea (Drupal still submits it)
          textarea.style.display = 'none';

          // Create editor container
          const container = document.createElement('div');
          container.classList.add('quill-wrapper');
          textarea.parentNode.insertBefore(container, textarea.nextSibling);

          // Init Quill
          const quill = new Quill(container, {
            theme: 'snow',
            modules: {
              toolbar: [
                ['bold', 'italic'],
                ['link']
              ]
            }
          });

          // Load existing value (if any)
          if (textarea.value) {
            quill.root.innerHTML = textarea.value;
          }

          // Sync Quill → textarea
          quill.on('text-change', () => {
            textarea.value = quill.root.innerHTML;
          });

        });

    }
  };

})(Drupal, once);
