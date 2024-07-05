<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
    <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
    <meta name="format-detection" content="date=no"> <!-- disable auto date linking in iOS -->
    <meta name="format-detection" content="address=no"> <!-- disable auto address linking in iOS -->
    <meta name="format-detection" content="email=no"> <!-- disable auto email linking in iOS -->
    <meta name="author" content="Jeremiah Iro">
    <title>{{ __('New Quiz Announcement') }} | {{ Config::get('settings.name') ?? config('app.name') }}</title>


    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <style type="text/css">
        /*Basics*/
        body {
            margin: 0px !important;
            padding: 0px !important;
            display: block !important;
            min-width: 100% !important;
            width: 100% !important;
            -webkit-text-size-adjust: none;
        }

        table {
            border-spacing: 0;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        table td {
            border-collapse: collapse;
            mso-line-height-rule: exactly;
        }

        td img {
            -ms-interpolation-mode: bicubic;
            width: auto;
            max-width: auto;
            height: auto;
            margin: auto;
            display: block !important;
            border: 0px;
        }

        td p {
            margin: 0;
            padding: 0;
        }

        td div {
            margin: 0;
            padding: 0;
        }

        td a {
            text-decoration: none;
            color: inherit;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /*Gmail blue links*/
        u+#body a {
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            font-family: inherit;
            font-weight: inherit;
            line-height: inherit;
        }

        /*Responsive*/
        @media screen and (max-width: 799px) {
            table.row {
                width: 100% !important;
                max-width: 100% !important;
            }

            td.row {
                width: 100% !important;
                max-width: 100% !important;
            }

            .img-responsive img {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                margin: auto;
            }

            .center-float {
                float: none !important;
                margin: auto !important;
            }

            .center-text {
                text-align: center !important;
            }

            .left-text {
                text-align: center !important;
            }

            .container-padding {
                width: 100% !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .container-padding10 {
                width: 100% !important;
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .hide-mobile {
                display: none !important;
            }

            .menu-container {
                text-align: center !important;
            }

            .autoheight {
                height: auto !important;
            }

            .m-padding-10 {
                margin: 10px 0 !important;
            }

            .m-padding-15 {
                margin: 15px 0 !important;
            }

            .m-padding-20 {
                margin: 20px 0 !important;
            }

            .m-padding-30 {
                margin: 30px 0 !important;
            }

            .m-padding-40 {
                margin: 40px 0 !important;
            }

            .m-padding-50 {
                margin: 50px 0 !important;
            }

            .m-padding-60 {
                margin: 60px 0 !important;
            }

            .m-padding-top10 {
                margin: 30px 0 0 0 !important;
            }

            .m-padding-top15 {
                margin: 15px 0 0 0 !important;
            }

            .m-padding-top20 {
                margin: 20px 0 0 0 !important;
            }

            .m-padding-top30 {
                margin: 30px 0 0 0 !important;
            }

            .m-padding-top40 {
                margin: 40px 0 0 0 !important;
            }

            .m-padding-top50 {
                margin: 50px 0 0 0 !important;
            }

            .m-padding-top60 {
                margin: 60px 0 0 0 !important;
            }

            .m-height10 {
                font-size: 10px !important;
                line-height: 10px !important;
                height: 10px !important;
            }

            .m-height15 {
                font-size: 15px !important;
                line-height: 15px !important;
                height: 15px !important;
            }

            .m-height20 {
                font-size: 20px !important;
                line-height: 20px !important;
                height: 20px !important;
            }

            .m-height25 {
                font-size: 25px !important;
                line-height: 25px !important;
                height: 25px !important;
            }

            .m-height30 {
                font-size: 30px !important;
                line-height: 30px !important;
                height: 30px !important;
            }

            .rwd-on-mobile {
                display: inline-block !important;
                padding: 5px;
            }

            .center-on-mobile {
                text-align: center !important;
            }
        }

        .main-btn {
            display: inline-block;
            font-weight: 500;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid #343e9e;
            padding: 0 35px;
            font-size: 16px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            line-height: 50px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 5;
            -webkit-transition: 0.4s ease-in-out;
            transition: 0.4s ease-in-out;
            background-color: #343e9e;
        }

        .main-btn:hover {
            color: #fff !important;
            border-color: #28317e;
            background-color: #28317e;
        }
    </style>

</head>

<body
    style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;"
    bgcolor="#fff">

    <span class="preheader-text"
        style="color: transparent; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; visibility: hidden; width: 0; display: none; mso-hide: all;"></span>

    <div
        style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">
    </div>

    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%"
        style="width:100%;max-width:100%;">
        <tr>
            <!-- Outer Table -->
            <td align="center" bgcolor="#fff" data-composer>

                <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%"
                    style="width:100%;max-width:100%;">
                    <!-- lotus-header-1 -->
                    <tr>
                        <td align="center" bgcolor="#fff" class="container-padding">

                            <!-- Content -->
                            <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation"
                                class="row" width="580" style="width:580px;max-width:580px;">
                                <tr>
                                    <td height="40" style="font-size:40px;line-height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <!-- Logo & Webview -->
                                        <table border="0" align="center" cellpadding="0" cellspacing="0"
                                            role="presentation" width="100%" style="width:100%;max-width:100%;">
                                            <tr>
                                                <td align="center" class="container-padding">

                                                    <!-- gap -->
                                                    <table border="0" align="right" cellpadding="0" cellspacing="0"
                                                        role="presentation" class="row" width="20"
                                                        style="width:20px;max-width:20px;">
                                                        <tr>
                                                            <td height="20" style="font-size:20px;line-height:20px;">
                                                                &nbsp;</td>
                                                        </tr>
                                                    </table>
                                                    <!-- gap -->

                                                    <!-- column -->
                                                    <table border="0" align="right" cellpadding="0" cellspacing="0"
                                                        role="presentation" class="row" width="280"
                                                        style="width:280px;max-width:280px;">
                                                        <tr>
                                                            <td align="left" class="center-text">
                                                                <a href="{{ url('/') }}">
                                                                    <img
                                                                        style="width:72px;height:72px;border:0px;display: inline!important;"
                                                                        src="{{ Config::get('settings.logo') ?? 'https://www.guardians-training.co.uk/wp-content/uploads/2023/04/Guardians_Training_Logo-1.png' }}"
                                                                        width="72" height="72" alt="logo">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- column -->

                                                </td>
                                            </tr>
                                        </table>
                                        <!-- Logo & Webview -->
                                    </td>
                                </tr>
                                <tr>
                                    <td height="40" style="font-size:40px;line-height:40px;">&nbsp;</td>
                                </tr>

                                @yield('content')

                                <tr>
                                    <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
                                </tr>
                            </table>
                            <!-- Content -->

                        </td>
                    </tr>
                </table>

                <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation"
                    width="100%" style="width:100%;max-width:100%;">
                    <!-- lotus-footer-1 -->
                    <tr>
                        <td align="center" bgcolor="#fff" class="container-padding">

                            <!-- Content -->
                            <table border="0" align="center" cellpadding="0" cellspacing="0"
                                role="presentation" class="row" width="580"
                                style="width:580px;max-width:580px;">
                                <tr>
                                    <td height="50" style="font-size:50px;line-height:50px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <!-- Social Icons -->
                                        <table border="0" align="center" cellpadding="0" cellspacing="0"
                                            role="presentation" width="100%" style="width:100%;max-width:100%;">
                                            <tr>
                                                <td align="center">
                                                    <table border="0" align="center" cellpadding="0"
                                                        cellspacing="0" role="presentation">
                                                        <tr>
                                                            <td class="rwd-on-mobile" align="center" valign="middle"
                                                                height="36" style="height: 36px;">
                                                                @if (Config::get('settings.facebook'))
                                                                    <table border="0" align="center"
                                                                        cellpadding="0" cellspacing="0"
                                                                        role="presentation">
                                                                        <tr>
                                                                            <td width="10"></td>
                                                                            <td align="center">
                                                                                <a
                                                                                    href="{{ Config::get('settings.facebook') }}"><img
                                                                                        style="width:36px;border:0px;display: inline!important;"
                                                                                        src="{{ asset('/jambasangsang/backend/assets/icons/facebook.png') }}"
                                                                                        width="36" border="0"
                                                                                        alt="icon"></a>
                                                                            </td>
                                                                            <td width="10"></td>
                                                                        </tr>
                                                                    </table>
                                                                @endif
                                                            </td>
                                                            <td class="rwd-on-mobile" align="center" valign="middle"
                                                                height="36" style="height: 36px;">
                                                                @if (Config::get('settings.instagram'))
                                                                    <table border="0" align="center"
                                                                        cellpadding="0" cellspacing="0"
                                                                        role="presentation">
                                                                        <tr>
                                                                            <td width="10"></td>
                                                                            <td align="center">
                                                                                <a
                                                                                    href="{{ Config::get('settings.instagram') }}">
                                                                                    <svg enable-background="new 0 0 24 24"  width="36" fill="inherit" viewBox="0 0 24 24" class="sc-gKsewC cVBMqs"><title data-testid="svgTitle" id="title_0.3254243059601658">instagram</title><path d="M21.938,7.71a7.329,7.329,0,0,0-.456-2.394,4.615,4.615,0,0,0-1.1-1.694,4.61,4.61,0,0,0-1.7-1.1,7.318,7.318,0,0,0-2.393-.456C15.185,2.012,14.817,2,12,2s-3.185.012-4.29.062a7.329,7.329,0,0,0-2.394.456,4.615,4.615,0,0,0-1.694,1.1,4.61,4.61,0,0,0-1.1,1.7A7.318,7.318,0,0,0,2.062,7.71C2.012,8.814,2,9.182,2,12s.012,3.186.062,4.29a7.329,7.329,0,0,0,.456,2.394,4.615,4.615,0,0,0,1.1,1.694,4.61,4.61,0,0,0,1.7,1.1,7.318,7.318,0,0,0,2.393.456c1.1.05,1.472.062,4.29.062s3.186-.012,4.29-.062a7.329,7.329,0,0,0,2.394-.456,4.9,4.9,0,0,0,2.8-2.8,7.318,7.318,0,0,0,.456-2.393c.05-1.1.062-1.472.062-4.29S21.988,8.814,21.938,7.71Zm-1,8.534a6.351,6.351,0,0,1-.388,2.077,3.9,3.9,0,0,1-2.228,2.229,6.363,6.363,0,0,1-2.078.388C15.159,20.988,14.8,21,12,21s-3.159-.012-4.244-.062a6.351,6.351,0,0,1-2.077-.388,3.627,3.627,0,0,1-1.35-.879,3.631,3.631,0,0,1-.879-1.349,6.363,6.363,0,0,1-.388-2.078C3.012,15.159,3,14.8,3,12s.012-3.159.062-4.244A6.351,6.351,0,0,1,3.45,5.679a3.627,3.627,0,0,1,.879-1.35A3.631,3.631,0,0,1,5.678,3.45a6.363,6.363,0,0,1,2.078-.388C8.842,3.012,9.205,3,12,3s3.158.012,4.244.062a6.351,6.351,0,0,1,2.077.388,3.627,3.627,0,0,1,1.35.879,3.631,3.631,0,0,1,.879,1.349,6.363,6.363,0,0,1,.388,2.078C20.988,8.841,21,9.2,21,12S20.988,15.159,20.938,16.244Z"></path><path d="M17.581,5.467a.953.953,0,1,0,.952.952A.954.954,0,0,0,17.581,5.467Z"></path><path d="M12,7.073A4.927,4.927,0,1,0,16.927,12,4.932,4.932,0,0,0,12,7.073Zm0,8.854A3.927,3.927,0,1,1,15.927,12,3.932,3.932,0,0,1,12,15.927Z"></path></svg>
                                                                                </a>
                                                                            </td>
                                                                            <td width="10"></td>
                                                                        </tr>
                                                                    </table>
                                                                @endif
                                                            </td>
                                                            <td class="rwd-on-mobile" align="center" valign="middle"
                                                                height="36" style="height: 36px;">
                                                                @if (Config::get('settings.twitter'))
                                                                    <table border="0" align="center"
                                                                        cellpadding="0" cellspacing="0"
                                                                        role="presentation">
                                                                        <tr>
                                                                            <td width="10"></td>
                                                                            <td align="center">
                                                                                <a
                                                                                    href="{{ Config::get('settings.twitter') }}">
                                                                                    <svg enable-background="new 0 0 24 24" width="36" viewBox="0 0 24 24" class="sc-gKsewC cVBMqs"><title data-testid="svgTitle" id="title_0.579685480455951">x</title><path fill="inherit" d="m2.538 3 7.425 9.928L2 21h1.5l7.033-7.067L16 21h5.232l-7.662-9.995 6.955-7.514h-1.5L13 10 7.77 3H2.538Zm1.994 1h2.645l12.087 16h-2.525L4.532 4Z"></path></svg>
                                                                                    </a>
                                                                            </td>
                                                                            <td width="10"></td>
                                                                        </tr>
                                                                    </table>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- Social Icons -->
                                    </td>
                                </tr>

                                <tr>
                                    <td class="center-text" align="center"
                                        style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:14px;line-height:24px;font-weight:400;font-style:normal;color:#000;text-decoration:none;letter-spacing:0px;">

                                        © {{ date('Y') }} {{ Config::get('settings.name') ?? config('app.name') }} - <a href="mailto:{{ config('app.support_email') }}" style="color:#343e9e;">
                                            <span>{{ config('app.support_email') }}</span>
                                        </a>. @lang('All rights reserved.')
                                    </td>
                                </tr>
                                <tr>
                                    <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
                                </tr>
                            </table>
                            <!-- Content -->

                        </td>
                    </tr>
                </table>

            </td>
        </tr><!-- Outer-Table -->
    </table>

</body>

</html>

