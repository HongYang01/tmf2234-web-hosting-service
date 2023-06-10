<?php

function paypalGetSubDetails(string $subID)
{

    $response = array();
    $access_token = "";

    try {

        /*######################################*
        ||          Get access_token          ||
        *######################################*/

        require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_2_accessToken.php");

        $access_token = getPayPalAccessToken();
        if ($access_token == null) {
            throw new Exception("Error: Failed to request token from PayPal");
        }

        /*######################################*
        ||          set URL options           ||
        *######################################*/

        $ch = curl_init();

        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/" . $subID;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer ' . $access_token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
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

Example returned from paypal

Array
(
    [status] => ACTIVE
    [status_update_time] => 2023-06-08T07:25:28Z
    [id] => I-3JT0KEUDW3XH
    [plan_id] => P-0GM50921FC832453RMR2XKDY
    [start_time] => 2023-06-08T07:25:07Z
    [quantity] => 1
    [shipping_amount] => Array
        (
            [currency_code] => USD
            [value] => 0.0
        )

    [subscriber] => Array
        (
            [email_address] => sb-tehix25986425@personal.example.com
            [payer_id] => 9LB2QJM6L9ZSU
            [name] => Array
                (
                    [given_name] => John
                    [surname] => Doe
                )

            [shipping_address] => Array
                (
                    [address] => Array
                        (
                            [address_line_1] => 1 Main St
                            [admin_area_2] => San Jose
                            [admin_area_1] => CA
                            [postal_code] => 95131
                            [country_code] => US
                        )

                )

        )

    [billing_info] => Array
        (
            [outstanding_balance] => Array
                (
                    [currency_code] => USD
                    [value] => 0.0
                )

            [cycle_executions] => Array
                (
                    [0] => Array
                        (
                            [tenure_type] => REGULAR
                            [sequence] => 1
                            [cycles_completed] => 1
                            [cycles_remaining] => 0
                            [current_pricing_scheme_version] => 1
                            [total_cycles] => 0
                        )

                )

            [last_payment] => Array
                (
                    [amount] => Array
                        (
                            [currency_code] => USD
                            [value] => 3.55
                        )

                    [time] => 2023-06-08T07:25:28Z
                )

            [next_billing_time] => 2023-07-08T10:00:00Z
            [failed_payments_count] => 0
        )

    [create_time] => 2023-06-08T07:25:27Z
    [update_time] => 2023-06-08T07:25:28Z
    [plan_overridden] => 
    [links] => Array
        (
            [0] => Array
                (
                    [href] => https://api.sandbox.paypal.com/v1/billing/subscriptions/I-3JT0KEUDW3XH/cancel
                    [rel] => cancel
                    [method] => POST
                )

            [1] => Array
                (
                    [href] => https://api.sandbox.paypal.com/v1/billing/subscriptions/I-3JT0KEUDW3XH
                    [rel] => edit
                    [method] => PATCH
                )

            [2] => Array
                (
                    [href] => https://api.sandbox.paypal.com/v1/billing/subscriptions/I-3JT0KEUDW3XH
                    [rel] => self
                    [method] => GET
                )

            [3] => Array
                (
                    [href] => https://api.sandbox.paypal.com/v1/billing/subscriptions/I-3JT0KEUDW3XH/suspend
                    [rel] => suspend
                    [method] => POST
                )

            [4] => Array
                (
                    [href] => https://api.sandbox.paypal.com/v1/billing/subscriptions/I-3JT0KEUDW3XH/capture
                    [rel] => capture
                    [method] => POST
                )

        )

)

*/