# Digitalia Custom Field Types Module

This module contains custom field types generated using `drush generate field`. Each type is made up of a number of subfields.These subfields are used across Digitalia MUNI ARTS platforms.

Each subfield is stored in a submodule and can be enabled individually.

Componants that are shared amongst subfields are contained in this parent module. Add the parent to dependencies if used in the submodule.

## Editor

Adds a simple editor to a text subfield.

Attach the library to the Widget
```
$element['#attached']['library'][] = 'digitalia_custom_field_type/editor';
```
and add the class 'quill-editor-inicialized' to the text fields you wish to use the editor on
```
      '#attributes' => [
        'class' => ['quill-editor-initialized'],
      ],
```
in editor.js on line 6 identify the fields to be used
```
'textarea[name^="field_{{parent}}"][name$="[{{subfield name}}]"]'
```

## Display details

CSS for a custom Display field formatter that uses a details element with an info icon. 

## Allowed language values

Returns allowed values for 'language' sub-field. ISO639-2.

In field type definition file add
```
use Drupal\digitalia_custom_field_types\Plugin\Field\FieldType\AllowedLanguageValuesTrait;
```

Inside class extending FieldItemBase add
```
use AllowedLanguageValuesTrait;
```