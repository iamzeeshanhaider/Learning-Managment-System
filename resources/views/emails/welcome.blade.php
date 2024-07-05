@extends('emails.layout.mail')

@section('content')
    <tr>
    <tr>
        <td align="center" class="center-text">
            <img style="width:190px;border:0px;display: inline!important;"
                src="https://github.com/simplepleb/laravel-email-templates/blob/main/public/assets/img/emails/Email-1_Intro.png?raw=true"
                width="190" border="0" alt="intro">
        </td>
    </tr>
    <tr>
        <td height="40" style="font-size:40px;line-height:40px;">&nbsp;</td>
    </tr>
    <tr>
        <td class="center-text" align="center"
            style="font-family:'Roboto Slab',Arial,Helvetica,sans-serif;font-size:42px;line-height:52px;font-weight:400;font-style:normal;text-decoration:none;letter-spacing:0px;">

            <div>
                Hey, {{ $data['lname'] }}
            </div>

        </td>
    </tr>
    <tr>
        <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
    </tr>
    <tr>
        <td class="center-text" align="center"
            style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">

            <div>
                <p>
                    Congratulations! Your account has been successfully created on
                    {{ Config::get('settings.name') ?? config('app.name') }}. We are thrilled to have you as a member of our
                    community.
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
    </tr>
    <tr>
        <td class="center-text" align="center"
            style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">
            <p>Here are your account details:</p>
            <br>
            <p>
                <b>Email:</b>
                <pre style="color: #000">{{ $data['email'] }}</pre> <br>
                <b>Password:</b>
                <pre style="color: #000">{{ $data['default_password'] }}</pre> <br>
                <small style="color:rgb(249, 12, 12)"><em>You are adviced to reset your
                        password</em></small>
            </p>
        </td>
    </tr>
    <tr>
        <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
    </tr>
    <tr>
        <td class="center-text" align="center"
            style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">

            <div>
                <p>
                    Please keep this information secure and do not share it with anyone.
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
    </tr>

    <tr>
        <td class="center-text" align="center"
            style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">

            <div>
                <p>
                    To get started, please visit our website and log in using your email and
                    password.
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td height="40" style="font-size:40px;line-height:40px;">&nbsp;</td>
    </tr>

    <tr>
        <td align="center">
            <!-- Header Button -->
            <table border="0" cellspacing="0" cellpadding="0" role="presentation" align="center" class="center-float">
                <tr>
                    <td align="center" bgcolor="#d6df58" style="border-radius: 6px;">
                        <a href="{{ config('app.url') . 'login?email=' . $data['email'] }}" target="_blank" class="main-btn"><span>Get Started</span></a>
                    </td>
                </tr>
            </table>
            <!-- Header Button -->
        </td>
    </tr>
    </tr>
@endsection
