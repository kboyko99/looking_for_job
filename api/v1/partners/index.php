<?php
$partnersJSON = file_get_contents('../../../admin/partners.json');
$partnersObj = json_decode($partnersJSON, true);
$output = '<ul>';
foreach ($partnersObj['partners'] as $partner) {
    if ($partner['hidden'] == '0'){
        $output .= '<h4>' . $partner['name'] . '</h4>';
        $output .= '<li>Description: ' . $partner['description'] . '</li>';
        $output .= '<li>Created at: ' . date('m/d/Y', $partner['createdAt']) . '</li>';
        $output .= '<li>Updated at: ' . date('m/d/Y', $partner['updatedAt']) . '</li>';
    }
}
$output .= '</ul>';
echo $output;