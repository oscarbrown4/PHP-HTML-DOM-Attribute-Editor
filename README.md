PHP-HTML-DOM-Attribute-Editor
=============================

This function takes html code and either replaces or adds to DOM element attributes.

processHTML takes two arguments:
the first is a string - the HTML code to be edited.
the second is an array of attributes and values.  values should be in an array themselves.

ie:

$attributes = 
    array(
      'div' =>
          array(
              'class' => 
                  array(
                      "class1",
                      "class2",
                      "class3"
                  ),
              'style' =>
                  array(
                      "font-size" => "16px",
                      "line-height" => "32px"
                  )
          )
      );
