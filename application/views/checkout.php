<!DOCTYPE html>
<html>
<?php $settings = $this->db->query("SELECT * FROM setting")->row();?>
<head>
    <title>120 ARMY - Checkout</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="<?= base_url() ?>uploads/logo/<?= $settings->favicon?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style type="text/css">
        #paypal-container-S9DZ7JWNC8WL6{text-align: center;}
        #paypal-form-fields-container-S9DZ7JWNC8WL6 {display: inline-block; width: 100%; background: #eee; padding: 20px; margin-top: 60px; border: 1px solid #eee; border-radius: 15px;}
        .paypal-buttons-context-iframe {left: 463px !important; width: 100% !important; display: block !important;}
        @media (min-width:320px)  {
            .paypal-buttons-context-iframe {left: 0px !important;}
            #paypal-container-S9DZ7JWNC8WL6{padding: 20px;}
        }
        @media (min-width:768px)  {
            .paypal-buttons-context-iframe {left: 125px !important;}
            .paypal-buttons-context-iframe {width: 65% !important;}
        }
        @media (min-width:1024px)  {
            .paypal-buttons-context-iframe {left: 248px !important;}
            .paypal-buttons-context-iframe {width: 50% !important;}
        }
        @media (min-width:1440px)  {
            .paypal-buttons-context-iframe {left: 458px !important;}
            .paypal-buttons-context-iframe {width: 35% !important;}
        }
        @media (min-width:2560px)  {
            .paypal-buttons-context-iframe {left: 40% !important;}
            .paypal-buttons-context-iframe {width: 20% !important;}
        }
    </style>
</head>
<body>
    <script src="https://www.paypal.com/sdk/js?client-id=BAAuRnUHRl1nhJdpVO7zOV_Js7uyVas4i1lKppDunkVYoDDOGTNPPg7zENXJPrlog71GvFNRf6Z_2di8go&components=hosted-buttons&enable-funding=venmo&currency=USD"></script>
    <div id="paypal-container-S9DZ7JWNC8WL6"></div>
    <script>
        paypal.HostedButtons({
            hostedButtonId: "S9DZ7JWNC8WL6",
        }).render("#paypal-container-S9DZ7JWNC8WL6")
    </script>
</body>
</html>
<script>
    $(document).ready(function() {
        //$('.paypal-buttons-context-iframe').css({ "left": "463px !important", "width": "35% !important" });
        setTimeout(function () {
            $('#amount').prop('readonly', true);
            $('#amount').val('<?= $total?>');
        }, 1500);
    })
</script>