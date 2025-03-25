<?php
function get_page_number() {
    $current_url = $_SERVER['REQUEST_URI'];
    if (preg_match('/page\/(\d+)/', $current_url, $matches)) {
        return (int)$matches[1];
    }
    return 1;
}