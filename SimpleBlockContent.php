<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# register plugin
register_plugin(
    $thisfile, 'SimpleBlockContent', '0.1.0', 'Luis Antonio', 'https://github.com/luis-agn', 'Replace place holders in pages with pages content', '', ''
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
    if (file_exists($file))
    {
        $data_index = getXML($file);
        $page = stripslashes(html_entity_decode($data_index->content, ENT_QUOTES, 'UTF-8'));
    }
    else
    {
        $page = "";
    }

    return $page;
}
