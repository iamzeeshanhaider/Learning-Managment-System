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
        font-size: 128px;
        text-align: center;
        text-transform: uppercase;
        font-family: 'Raleway', sans-serif;
        color: rgb(201 198 198);
        font-weight: bolder;
        letter-spacing: 5px;
        line-height: 100px;
    }

    /* top */
    .top-angle {
        position: absolute;
        top: 0;
        right: 0;
    }
    .cert-content {
        padding: 40px 0;
        width: 100%;
    }

    .cert-content .logo {
        position: absolute;
        left: 30px;
    }

    .cert__title-container {
        text-align: center;
        font-family: 'Raleway', sans-serif;
        text-transform: uppercase;
    }

    .cert__title {
        margin: 0;
        font-size: 54px;
    }

    .cert__title-addon {
        font-size: 34px;
    }
    /* top */


    /* main */
    .cert__user {
        position: absolute;
        top: 48%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 0;
        box-sizing: border-box;
        text-align: center;
        width: 80%;
        margin: 20px auto;
    }

    .cert__user-username,
    .cert__user-course,
    .issue__date-value,
    .signatory__title,
    .signatory__designation {
        font-family: 'Raleway', sans-serif;
        color: #3A55A4;
        margin: 4px auto;
        font-weight: 600;
    }

    .cert__user-username {
        border-bottom: 2px solid #000;
        font-weight: 700;
        font-size: 48px;
    }

    .cert__user-course {
        font-size: 34px;
    }

    .cert__user-addon {
        font-size: 24px;
    }
    /* main */

    /* bottom */
    .bottom-angle {
        position: absolute;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
    }

    .table {
        position: absolute;
        left: 0;
        bottom: 100px;
        right: 0;
        width: 100%;
        height: 100px;
    }

    .ba-info {
        font-size: 10px;
    }

    .ba-info i,
    .ba-info span a {
        color: #fff;
        text-decoration: none;
    }

    .ba-info div {
        padding: 6px 0;
    }

    .ba-info svg {
        margin-bottom: -3px;
    }
    .signatory__signature {
        font-family: 'Mr De Haviland', cursive;
        border-bottom: 2px solid #000;
        font-size: 30px;
    }

    .signatory__title {
        margin: 0;
    }

    .signatory__designation {
        font-weight: 300;
        margin: 0;
    }

    .issue__date-title {
        letter-spacing: 2px;
    }
    /* bottom */


    /* addon */
    .w-100 {
        width: 100%;
    }

    .w-2-3 {
        width: 33.33%;
    }

    .p-20 {
        padding: 20px;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }
</style>
