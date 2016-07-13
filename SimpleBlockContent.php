<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# register plugin
register_plugin(
    $thisfile, 'SimpleBlockContent', '0.2.0', 'Luis Antonio', 'https://github.com/dr0m', 'Replace place holders in pages with pages content', '', ''
);

# activate filter
add_filter('content', 'simple_block_content_replace');

function simple_block_content_replace($content)
{
    return preg_replace_callback("/(<p>\s*)?{%\s*(?P<slug>[a-zA-Z0-9_-]+)\s*%}(\s*<\/p>)?/", 'simple_block_content_match', $content);
}

function simple_block_content_match($match)
{
    $id = $match['slug'];
    $file = 'data/pages/'.$id.'.xml';

    if (function_exists('return_i18n_page_data'))
        $data = return_i18n_page_data($id);
    elseif (file_exists($file))
        $data = getXML($file);
    else
        $page = '';

    if (isset($data))
        $page = stripslashes(html_entity_decode($data->content, ENT_QUOTES, 'UTF-8'));

    return $page;
}
