@extends('emails.layout.mail')
@section('content')
    <tr>
    <tr>
        <td class="left-text" align="left"
            style="font-family:'Roboto Slab',Arial,Helvetica,sans-serif;font-size:42px;line-height:52px;font-weight:400;font-style:normal;text-decoration:none;letter-spacing:0px;">

            <div>
                Dear, {{ $data['lname'] }}
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
                    Your quiz submission has been graded
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
            <p>Quiz Details:</p>
            <br>
            <div style="padding-left: 20px;">
                <p>&check; Lesson: {{ $data['lesson_title'] }}</p>
                @if ($data['quiz_start_time'])
                    <p>
                        &check; Quiz Start on: {{ $data['quiz_start_time']->format('l, d Y') }} by
                        {{ $data['quiz_start_time']->format('H:i A') }}
                    </p>
                @endif
                @if ($data['quiz_end_time'])
                    <p>
                        &check; Quiz Ends on: {{ $data['quiz_end_time']->format('l, d Y') }} by
                        {{ $data['quiz_end_time']->format('H:i A') }}
                    </p>
                @endif
                <p>
                    &check; Date of Submission: {{ $data['submission_date']->diffForHumans() }}
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
    </tr>
    <tr>
        <td align="center">
            <table border="0" cellspacing="0" cellpadding="0" role="presentation" align="center" class="center-float">
                <tr>
                    <td align="center" bgcolor="#d6df58" style="border-radius: 6px;">
                        <a href="{{ $data['submission_url'] }}" target="_blank" class="main-btn"><span>View Score</span></a>
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
                If you have any questions or require further information regarding the course, please do not hesitate to
                reach out to the Course Coordinator - <a
                    href="mailto:{{ config('app.support_email') }}" style="color:#343e9e;">{{ config('app.support_email') }}</a>. They will be
                happy to assist you.
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
                Best regards, <br>
            </p>
        </td>
    </tr>
    </tr>
@endsection
