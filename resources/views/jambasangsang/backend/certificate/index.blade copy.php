<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ Config::get('settings.name') }} | Certificate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    @font-face {
        font-family: 'Montserrat';
        src: url({{ public_path('/pdf-fonts/Montserrat/static/Montserrat-Regular.ttf') }}) format("truetype");
        font-weight: regular;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url({{ public_path('/pdf-fonts/Montserrat/static/Montserrat-SemiBold.ttf') }}) format("truetype");
        font-weight: bold;
        font-style: normal;
    }

    @font-face {
        font-family: 'Raleway';
        src: url({{ public_path('/pdf-fonts/Raleway/static/Raleway-ExtraBold.ttf') }}) format("truetype");
        font-weight: bolder;
        font-style: normal;
    }

    @font-face {
        font-family: 'Mr De Haviland';
        src: url({{ public_path('/pdf-fonts/Mr_De_Haviland/MrDeHaviland-Regular.ttf') }}) format("truetype");
        font-weight: regular;
        font-style: normal;
    }

    body {
        margin: 0;
        padding: 0;
        overflow: hidden;
        font-family: 'Montserrat', sans-serif;
    }

    .container {
        width: 90%;
        height: 90vh;
        padding: 20px;
        margin: 10px auto;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        background-image: url({{ asset('/jambasangsang/placeholder_2.png') }});
    }

    @media print {
        .container {
            -webkit-print-color-adjust: exact;
        }
    }

    .content {
        background: whitesmoke;
        position: relative;
        height: 100%;
        width: 100%;
        z-index: 0;
    }

    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: -1;
        opacity: 0.1;
        font-size: 8em;
        text-align: center;
        text-transform: uppercase;
        font-family: 'Raleway', sans-serif;
        color: rgb(201 198 198);
        font-weight: bolder;
        letter-spacing: 5px;
        line-height: 100px;
    }

    .top-angle {
        position: absolute;
        top: 0;
        right: 0;
    }

    .bottom-angle {
        position: absolute;
        bottom: -4px;
        left: 0;
    }

    .bottom-angle-content {
        position: relative;
    }

    .ba-content {
        position: absolute;
        top: 35%;
        color: white;
        padding: 30px;
        width: 70%;
        margin: auto;
    }

    .ba-info {
        font-size: 10px;
    }

    .ba-info div {
        padding: 6px 0;
    }

    .ba-info svg {
        margin-bottom: -3px;
    }

    .ba-info a {
        color: #fff;
        text-decoration: none;
    }

    .cert-content {
        padding: 40px 0;
        width: 100%;
    }

    .cert-content .title {
        text-align: center;
        font-family: 'Raleway', sans-serif;
    }

    .cert-content .logo {
        position: absolute;
        left: 30px;
    }

    .cert-content .title h1 {
        font-size: 4em;
        text-transform: uppercase;
        font-weight: 700;
        margin: 0 auto;
    }

    .cert-content .title p {
        font-size: 2em;
        text-transform: uppercase;
        font-weight: 500;
        margin-top: -10px;
    }

    .cert-user {
        text-align: center;
        min-width: 50%;
        max-width: 80%;
        margin: 10% auto;
    }

    .cert-user .username,
    .cert-user .course,
    .cert-footer-data .title,
    .cert-footer-data .designation {
        font-family: 'Raleway', sans-serif;
        color: #3A55A4;
        margin: 8px auto;
        font-weight: 600;
    }

    .cert-footer-data .title {
        margin-top: 0;
    }

    .cert-user .username {
        border-bottom: 2px solid #000;
        font-size: 3.4em;
        font-weight: 700;
    }

    .cert-user .course {
        font-size: 1.4em;
    }

    .cert-footer-data {
        width: 25%;
        margin: auto;
        text-align: center;
        /* padding-left: 20px; */
    }

    /* .cert-footer .data {
        float: left;
    } */

    .cert-footer-date {
        float: right;
    }

    .cert-footer-date-content {
        text-align: right;
        margin-right: 40px;
    }

    .cert-footer-date span {
        letter-spacing: 1px;
        font-size: 12px;
    }

    .cert-footer-data .signature {
        font-family: 'Mr De Haviland', cursive;
        border-bottom: 2px solid #000;
        font-size: 30px;
    }

    .cert-footer-data .designation {
        font-weight: 300;
    }
</style>

<body>
    <div class="container">
        <div class="content">
            <span class="watermark">
                Guardians Training
            </span>
            <div class="top-angle">
                <img class="logo" src="{{ asset('/certificate/f2.png') }}" alt="{{ config('app.name') }}">
            </div>

            <div class="cert-content">
                <img class="logo" src="{{ Config::get('settings.logo') }}" width="100" alt="Logo">
                <div class="cert-title">
                    <div class="title">
                        <h1>Certificate</h1>
                        <p>of Completion</p>
                    </div>

                    <div class="cert-user">
                        <span class="addon">
                            This is to certify that,
                        </span>
                        <h1 class="username">
                            {{ ucwords($data['name']) }}
                        </h1>
                        <span class="addon">
                            has successfully completed the course,
                        </span>
                        <h2 class="course">
                            {{ ucwords($data['courseTitle']) }}
                        </h2>
                    </div>
                </div>
                <div class="cert-footer-data">
                    <div class="signature">
                        Jeremiah Iromaka
                    </div>
                    <div class="title">
                        James Doe
                    </div>
                    <div class="designation">
                        Chief Executive
                    </div>
                </div>
                <div class="cert-footer-date">
                    <div class="cert-footer-date-content">
                        <span>Date of Issue</span>
                        <div class="title">{{ $data['issueDate']->format('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="bottom-angle">
                <div class="bottom-angle-content">
                    <img class="logo" src="{{ asset('/certificate/f1.png') }}" alt="{{ config('app.name') }}">

                    <div class="ba-content">
                        <div class="ba-content-icon">
                            <img src="{{ asset('certificate/sage.png') }}" width="38px" height="35px"
                                style="border-radius: 10px" alt="">
                            <img src="{{ asset('certificate/xero.png') }}" width="38px" height="35px"
                                style="border-radius: 10px" alt="">
                            <img src="{{ asset('certificate/quickbooks.png') }}" width="38px" height="35px"
                                style="border-radius: 10px" alt="">
                        </div>
                        <div class="ba-info">
                            <div>
                                <i class="fas fa-map-marker"></i>

                                <span>
                                    <a href="https://www.google.com/maps?ll=51.519404,-0.133893&z=16&t=m&hl=en&gl=GB&mapclient=embed&cid=6929397451900679875"
                                        target="_blank">Kirkman House, 12/14 Whitefield Street, London, W1T 2RF</a>
                                </span>
                            </div>
                            <div>
                                <i class="fas fa-phone"></i>

                                <span>
                                    <a href="tel:+44(0) 20 3371 9904" target="_blank">+44(0) 20 3371 9904</a>
                                </span>
                            </div>
                            <div>
                                <i class="fas fa-envelope"></i>

                                <span>
                                    <a href="mailto:info@guardians-training.co.uk"
                                        target="_blank">info@guardians-training.co.uk</a>
                                </span>
                            </div>
                            <div>
                                <i class="fas fa-globe"></i>
                                <span>
                                    <a href="https://www.guardians-training.co.uk/"
                                        target="_blank">https://www.guardians-training.co.uk/</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
