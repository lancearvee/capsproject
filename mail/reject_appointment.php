<!DOCTYPE html>
<html lang="en">

<head>
    <title>Appointment Confirmation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div style="width: 600px; margin: auto; overflow: hidden; border: 1px solid #E5E5E5;">
        <table width="600px" cellspacing="0" cellpadding="0" style="position: relative; border: none;">
            <tbody>
                <tr>
                    <td>
                        <table width="100%">
                            <tr style="text-align: center;">
                                <td>
                                    <p style="font-weight: bold; font-size: 35px;">
                                        <span style="color: #f633ff;">Thyroid Health and Wellness Center</span>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="background: #fff; font-size: 25px; padding: 0 26px; text-align: center;">
                        <p style="font-size: 18px;">Dear <?php echo $given_name; ?>,</p>
                        <p style="font-size: 18px;">We’re sorry to inform you that your appointment has been declined due to an issue at our clinic. 
                            We sincerely apologize for any inconvenience this may cause. Please reschedule your appointment via our website. 
                            Thank you for your understanding.</p>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #EEFDEB; margin-top: 10px; padding: 10px; text-align: center;">
                        <p style="font-size: 24px; font-weight: bold; color: #000;">Appointment Details</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 25px;">
                        <table width="100%" style="border-radius: 5px; border: 1px solid #000; padding: 13px 25px;">
                            <tr>
                                <td style="font-size: 20px; font-weight: 600;">Date: <?php echo $appointmentDetails['date']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 20px; font-weight: 600;">Time: <?php echo $appointmentDetails['time_from']; ?> - <?php echo $appointmentDetails['time_to']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
