<?php
$partnersJSON = file_get_contents('../../../admin/partners.json');
$partnersObj = json_decode($partnersJSON, true);
if (count($partnersObj['partners'])){
    $output;
    foreach ($partnersObj['partners'] as $partner) {
        if ($partner['hidden'] == '0'){
            unset($partner['hidden']);
            $output[] = $partner;
        }
    }
}else {
    $output = [];
}
echo json_encode($output);