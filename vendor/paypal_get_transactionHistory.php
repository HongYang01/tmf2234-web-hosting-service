<?php

function paypalGetPaymentHistory(string $sub_id)
{

    require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_2_accessToken.php");

    try {

        $start_time = "2020-01-01T00:00:00.000Z";
        $end_time = date('Y-m-d\TH:i:s\Z', strtotime('+1 day')); // one day ahead today (to make sure capture all)
        $response = array();

        $access_token = getPayPalAccessToken();
        if ($access_token == null) {
            throw new Exception("PayPal Error: Failed to get access token");
        }

        $ch = curl_init();

        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/" . $sub_id . "/transactions?";
        $url .= "start_time=" . $start_time;
        $url .= "&";
        $url .= "end_time=" . $end_time;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer ' . $access_token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch); // execute URL and return as JSON (set in Content-Type)
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // get response HTTP code
        curl_close($ch);

        if ($http_code >= 400 && $http_code < 600) {
            throw new Exception("PayPal Error " . $http_code . ": " . PAYPAL_HTTP_ERR_MSG($http_code));
        } else {
            $response = json_decode($result, true);
        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

    return $response;
}

/*

Returned JSON

Array
(
    [transactions] => Array
        (
            [0] => Array
                (
                    [status] => COMPLETED
                    [id] => 6LV760727F056501T
                    [amount_with_breakdown] => Array
                        (
                            [gross_amount] => Array
                                (
                                    [currency_code] => USD
                                    [value] => 3.55
                                )

                            [fee_amount] => Array
                                (
                                    [currency_code] => USD
                                    [value] => 0.61
                                )

                            [net_amount] => Array
                                (
                                    [currency_code] => USD
                                    [value] => 2.94
                                )

                        )

                    [payer_name] => Array
                        (
                            [given_name] => John
                            [surname] => Doe
                        )

                    [payer_email] => sb-tehix25986425@personal.example.com
                    [time] => 2023-06-05T04:00:46.000Z
                )

        )

    [links] => Array
        (
            [0] => Array
                (
                    [href] => https://api-m.sandbox.paypal.com/v1/billing/subscriptions/I-5L38FMR0SAN5/transactions?start_time=2020-01-01T00%3A00%3A00.940Z&end_time=2023-06-06T10%3A14%3A33Z
                    [rel] => SELF
                    [method] => GET
                )

        )

)

*/