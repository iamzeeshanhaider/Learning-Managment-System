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
    @include('jambasangsang.backend.certificate.partials.stylesheet')
</head>

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
                <div class="">
                    <div class="cert__title-container">
                        <h1 class="cert__title">Certificate</h1>
                        <span class="cert__title-addon">of Completion</span>
                    </div>

                    <div class="cert__user">
                        <span class="cert__user-addon">
                            This is to certify that,
                        </span>
                        <h1 class="cert__user-username">
                            {{ ucwords($data['name']) }}
                        </h1>
                        <span class="cert__user-addon">
                            has successfully completed the course,
                        </span>
                        <h2 class="cert__user-course">
                            {{ ucwords($data['courseTitle']) }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="bottom-angle">
                <img class="logo" src="{{ asset('/certificate/f1.png') }}" alt="{{ config('app.name') }}">
            </div>

            <table class="w-100 table">
                <tr>
                    <td>
                        <table class="w-100">
                            <tr class="w-100">
                                <td align="left" class="w-2-3 text-left p-20">
                                    <div class="address">
                                        <div class="ba-content-icon">
                                            <img src="{{ asset('certificate/sage.png') }}" width="38px"
                                                height="35px" style="border-radius: 10px" alt="">
                                            <img src="{{ asset('certificate/xero.png') }}" width="38px"
                                                height="35px" style="border-radius: 10px" alt="">
                                            <img src="{{ asset('certificate/quickbooks.png') }}" width="38px"
                                                height="35px" style="border-radius: 10px" alt="">
                                        </div>
                                        <div class="ba-info">
                                            <div>
                                                <i class="fas fa-map-marker"></i>

                                                <span>
                                                    <a href="https://www.google.com/maps?ll=51.519404,-0.133893&z=16&t=m&hl=en&gl=GB&mapclient=embed&cid=6929397451900679875"
                                                        target="_blank">Kirkman House, 12/14 Whitefield Street, <br>
                                                        London, W1T 2RF</a>
                                                </span>
                                            </div>
                                            <div>
                                                <i class="fas fa-phone"></i>

                                                <span>
                                                    <a href="tel:+44(0) 20 3371 9904" target="_blank">+44(0) 20 3371
                                                        9904</a>
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
                                                        target="_blank">https://www.guardians-training.co.uk</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="w-2-3 text-center">
                                    <div class="signatory">
                                        <div class="signatory__signature">
                                            {{ Config::get('settings.signatory') }}
                                        </div>
                                        <h3 class="signatory__title">
                                            {{ Config::get('settings.signatory') }}
                                        </h3>
                                        <div class="signatory__designation">
                                            Chief Executive
                                        </div>
                                    </div>
                                </td>
                                <td align="right" class="w-2-3">
                                    <div class="text-right p-20">
                                        <span class="issue__date-title">Date of Issue</span>
                                        <div class="issue__date-value">{{ $data['issueDate']->format('d F Y') }}</div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</body>

</html>
