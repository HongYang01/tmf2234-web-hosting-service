<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

try {

    $hostingType = array();
    $data = array();

    //get hosting type
    $query = "SELECT DISTINCT prod_category FROM product";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($hostingType, $row['prod_category']);
            }
        } else {
            throw new Exception("Success query: No hosting type found");
        }
    } else {
        throw new Exception("Error: Failed to query");
    }

    foreach ($hostingType as $temp) {
        $query = "SELECT * FROM payments WHERE product_id = " . $temp . "";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                array_push($data, mysqli_num_rows($result));
            } else {
                throw new Exception("Success query: No payment found");
            }
        } else {
            throw new Exception("Error: Failed to query");
        }
    }
} catch (Exception $e) {
    // Handle the specific exception
    $reponse = array('success' => false, 'message' => $e->getMessage());
    echo json_encode($reponse);
    exit;
}

$reponse = array('success' => true, 'hostingType' => $hostingType, 'data' => $data);
echo json_encode($reponse);
exit;

//TODO: create actual piechart


/**
 * Generate a range of colors using the HSL color model.
 * usage: $colors = generateColors(count($data));
 *
 * @param int $count The number of colors to generate.
 * @param float $startHue The starting hue value (0-360).
 * @param float $saturation The saturation value (0-100).
 * @param float $lightness The lightness value (0-100).
 * @return array The generated colors.
 */
function generateColors($count, $startHue = 0, $saturation = 70, $lightness = 50)
{
    $colors = [];

    for ($i = 0; $i < $count; $i++) {
        $hue = $startHue + ($i * (360 / $count));
        $color = "hsl($hue, $saturation%, $lightness%)";
        $colors[] = $color;
    }

    return $colors;
}
