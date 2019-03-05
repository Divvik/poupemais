<?php

// Filter input post
function filter_input_post($input_value)
{
    return filter_input(INPUT_POST, $input_value, FILTER_SANITIZE_SPECIAL_CHARS);
}