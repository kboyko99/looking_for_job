<?php
function transliterate($string)
{
    if (is_string($string)) {
        $cyr = ['ж', 'ч', 'щ', 'ш', 'ю', 'ы', '`', '’', '\'', '"', '’',
            'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о',
            'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я', 'Ж', 'Ч', 'Щ', 'Ш', 'Ю',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
            'Х', 'Ц', 'Ъ', 'Ь', 'Я',
            'і', 'І', 'ї', 'Ї', 'є', 'Є', 'ё', 'Ё', 'ґ', 'Ґ',
        ];
        $lat = ['zh', 'ch', 'shch', 'sh', 'yu', 'i', '', '', '', '', '',
            'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o',
            'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', '', 'ya', 'Zh', 'Ch', 'Sht', 'Sh', 'Yu',
            'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F',
            'H', 'c', '', '', 'Ya',
            'i', 'I', 'Yi', 'yi', 'Ye', 'ye', 'e', 'E', 'g', 'G',
        ];
        return str_replace($cyr, $lat, html_entity_decode($string, ENT_QUOTES));
    } else {
        return false;
    }
}

$partnersJSON = file_get_contents('partners.json');
$partnersObj = json_decode($partnersJSON, true);

$name = $_POST['name'];
$description = $_POST['description'];
$uploadTempFile = $_FILES['image']['tmp_name'];

if (isset($name) && isset($description) && isset($uploadTempFile)) {
    $partner = array(
        'id' => (new DateTime())->getTimestamp(),
        'name' => transliterate($name),
        'description' => $description
    );

    list( $uploadWidth, $uploadHeight, $uploadType ) = getimagesize( $uploadTempFile );

    $aspectRatio = $uploadWidth / $uploadHeight;
    if ($aspectRatio > 1) {
        $newWidth = 200;
        $newHeight = $newWidth / $aspectRatio;
    } else {
        $newHeight = 200;
        $newWidth = $newHeight * $aspectRatio;
    }

    if ($uploadType == 2) {
        $srcImage = imagecreatefromjpeg($uploadTempFile);
    } else if ($uploadType == 3) {
        $srcImage = imagecreatefrompng($uploadTempFile);
    }

    $targetImage = imagecreatetruecolor($newWidth, $newHeight);
    imagealphablending( $targetImage, false );
    imagesavealpha( $targetImage, true );

    imagecopyresampled( $targetImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $uploadWidth, $uploadHeight);

    if (!file_exists('../images/partners/')) {
        mkdir('../images/partners/', 0777, true);
    }
    if ($uploadType == 2) {
        $filePath = '../images/partners/' . transliterate($name) . '.jpg';
        imagejpeg($targetImage, $filePath , 90);
    } else if ($uploadType == 3) {
        $filePath = '../images/partners/' . transliterate($name) . '.png';
        imagepng($targetImage, $filePath , 9 );
    }

    $partner["imageLink"] = $filePath;
    $partner["hidden"] = isset($_POST["hidden"]) ? "1" : "0";
    $date = new DateTime();
    $partner["createdAt"] = $date->getTimestamp();
    $partner["updatedAt"] = "";
    $partnersObj["partners"][] = $partner;
    $partnersEncoded = json_encode($partnersObj);
    imagedestroy($srcImage);
    file_put_contents("partners.json", $partnersEncoded);
    header('Location: ../admin?ok=ok');
    exit();
}
?>