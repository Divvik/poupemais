<?php

namespace Src\Core;

class Layout
{
    public function setHead()
    {
        $html  = "<!DOCTYPE html>\n";
        $html .= "<html lang='pt-br'>\n";
        $html .= "<head>\n";
        $html .= "<meta charset='utf-8'>\n";
        $html .= "<meta name='viewport' content='width=device-width, initial-scale=1'>\n";
        $html .= "<meta name='author' content='Dog-developer'>";
        $html .= "<meta name='format-detection' content='telephone=no'>\n";
        $html .= "<meta name='description' content='$description'>\n";
        $html .= "<title>$title</title>\n";
        # FAVICON
        #STYLESHEET
        $html .= "<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet'>\n";
        $html .= "<link rel='stylesheet' href='" . DIRCSS . "'style.css'>\n";
        # FAVICON
        #STYLESHEET
        $html .= "</head>\n";
        $html .= "<body>\n";
            
    }
}