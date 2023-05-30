<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="paypal-button-container-P-8SM252323T120453TMR2K4SQ"></div>
    <script src="https://www.paypal.com/sdk/js?client-id=AcGiJABvQOLZrBw6RVcGvIRfjb7hUqlsbBVjvmake2oKdTjC3RtPMfvFI2wv0u99rKmkZpgTddQyva1v&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
    <script>
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'subscribe'
            },
            createSubscription: function(data, actions) {
                return actions.subscription.create({
                    /* Creates the subscription */
                    plan_id: '<?php echo "P-8SM252323T120453TMR2K4SQ"; ?>'
                });
            },
            onApprove: function(data, actions) {
                alert(data.subscriptionID); // You can add optional success message for the subscriber here
            }
        }).render('#paypal-button-container-P-8SM252323T120453TMR2K4SQ'); // Renders the PayPal button
    </script>
</body>

</html>