@extends('emails.layout.mail')

@section('content')
    <tr>
    <tr>
        <td class="left-text" align="left"
            style="font-family:'Roboto Slab',Arial,Helvetica,sans-serif;font-size:42px;line-height:52px;font-weight:400;font-style:normal;text-decoration:none;letter-spacing:0px;">

            <div>
                Dear, {{ $data['lname'] ?? '' }}
            </div>

        </td>
    </tr>
    <tr>
        <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
    </tr>
    <tr>
        <td class="left-text" align="left"
            style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">
            <div>
                <p>
                    We are pleased to inform you that you have been successfully enrolled in the {{ $data['course_title'] ?? '' }}
                    for the upcoming semester. Congratulations!
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
    </tr>
    <tr>
        <td class="left-text" align="left"
            style="padding-left: 20px;font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">
            <p>Course Details:</p>
            <br>
            <div style="padding-left: 20px;">
                <p> Course Title: {{ $data['course_title'] ?? '' }}</p>
                <p> Course Code: {{ $data['course_code'] ?? '' }}</p>
            </div>
        </td>
    </tr>
    <tr>
        <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
    </tr>
    <tr>
        <td class="left-text" align="left"
            style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">
            <p>
                Please take note of the course details mentioned above and make sure to mark your calendar accordingly. We
                encourage you to familiarize yourself with the syllabus and any additional course materials that may be
                provided by the instructor.
            </p>
        </td>
    </tr>
    <tr>
        <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
    </tr>

    <tr>
        <td class="left-text" align="left"
            style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">
            <p>
                If you have any questions or require further information regarding the course, please do not hesitate to
                reach out to the Course Coordinator -
                <a href="mailto:{{ config('app.support_email') }}" style="color: #343e9e;">{{ config('app.support_email') }}</a>. They will be
                happy to assist you.
            </p>
        </td>
    </tr>

    <tr>
        <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
    </tr>

    <tr>
        <td align="center">
            <table border="0" cellspacing="0" cellpadding="0" role="presentation" align="center" class="center-float">
                <tr>
                    <td align="center" style="border-radius: 6px;">
                        <a href="{{ $data['course_url'] ?? '' }}" target="_blank" class="main-btn"><span>Start Leaning</span></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
    </tr>

    <tr>
        <td class="left-text" align="left"
            style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">
            <p>
                We look forward to having you in the {{ $data['course_title'] ?? '' }} and believe that you will find it engaging
                and beneficial. We wish you the best of luck and success in this course.
            </p>
        </td>
    </tr>
    <tr>
        <td height="40" style="font-size:40px;line-height:40px;">&nbsp;</td>
    </tr>

    <tr>
        <td class="left-text" align="left"
            style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">
            <p>
                Best regards, <br>
            </p>
        </td>
    </tr>
    </tr>
@endsection
