<?php
/*
 * php function that converts post text to piglatin
 */

// Hook the 'the_content' filter hook (content of any post), run the function named 'mfp_Fix_Text_Spacing'
add_filter("the_content", "mpp_convert_to_piglatin");
 
// Add a new top level menu link to the ACP
function mpp_convert_to_piglatin($the_Post)
{
  // the conversion code below
  function rotate($a)
    {
        $rotatedstring = substr($a, 1, strlen($a) - 1) . substr($a, 0, 1);
        return $rotatedstring;
    }

    $alphabet = array('a' => "v", 'b' => "c", 'c' => "c", 'd' => "c", 'e' => "v",
    'f' => "c", 'g' => "c", 'h' => "c", 'i' => "v", 'j' => "c", 'k' => "c", 'l' =>
    "c", 'm' => "c", 'n' => "c", 'o' => "v", 'p' => "c", 'q' => "c", 'r' => "c", 's' =>
    "c", 't' => "c", 'u' => "v", 'v' => "c", 'w' => "c", 'x' => "c", 'y' => "c", 'z' =>
    "c");

    $line = (get_magic_quotes_gpc()) ? stripslashes($the_Post) : $the_Post;

    print '<html><h2>Original post: </h2>' . $line . '<p>';

    $words = explode(' ', $line);
    $index = 0;

    foreach ($words as $word)
    {
        $tword = trim($word);
        $word = $tword;
        $first = substr($word, 0, 1);
        if ($alphabet[$first] == 'v')
        {
            $pig = $word . 'way';

        }
        else
        {
            $pig = rotate($word);
            $word = $pig;
            $first = substr($word, 0, 1);

            while ($alphabet[$first] == 'c')
            {
                $pig = rotate($word);
                $word = $pig;
                $first = substr($word, 0, 1);
            }
            $pig = $word . 'ay';
        }
        $pigword[$index] = $pig;
        $index = $index + 1;
    }

    $piglatin = implode(' ', $pigword);

    echo '<h2>Post In Pig Latin: </h2>' . ucwords(strtolower($piglatin));
    echo '</html>';
}



/*
 * Add a new menu to the Admin Control Panel
 */
 
// Hook the 'admin_menu' action hook, run the function named 'mfp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'mpp_Add_Admin_Link' );
 
// Add a new top level menu link to the ACP
function mpp_Add_Admin_Link()
{
      add_menu_page(
        'Moses Post Piglatin page', // Title of the page
        'Moses Post Piglatin', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'includes/mpp-post-piglatin-cp.php' // The 'slug' - file to display when clicking the link
    );
}