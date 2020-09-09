<?php
ini_set('error_reporting', E_ALL); ini_set('display_errors', 1);

    function createHeader() 
    {
        $dom = new DOMDocument('1.0', 'utf-8');

        //Masthead container
        $container = $dom->createElement('div');
        $container->setAttribute('class', 'header');

        //Banner container
        $banner = $dom->createElement('div');
        $banner->setAttribute('id', 'banner');

        //Link to home
        $link = $dom->createElement('a');
        $link->setAttribute('href', './');

        //Banner image
        $image = $dom->createElement('img');
        $image->setAttribute('src', './images/quest_logo.png');

        //Nest the elements
        $link->appendChild($image);
        $banner->appendChild($link);
        $container->appendChild($banner);
        $dom->appendChild($container);

        return $dom;
    }

    $header = createHeader();

    echo $header->saveHTML();
?>