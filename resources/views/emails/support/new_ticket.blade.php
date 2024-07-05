@extends('emails.layout.mail')

@section('content')
    <tr>
        <tr>
            <td class="center-text" align="left"
                style="font-family:'Roboto Slab',Arial,Helvetica,sans-serif;font-size:42px;line-height:52px;font-weight:400;font-style:normal;text-decoration:none;letter-spacing:0px;">

                <div>
                    @if($role === 'student')
                        Dear, {{ ucwords($ticket->user->name) }}
                    @else
                        Hello,
                    @endif
                </div>

            </td>
        </tr>
        <tr>
            <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
        </tr>
        <tr>
            <td class="center-text" align="left"
                style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">

                <div>
                    <h2>{{ $subject }}</h2>
                    <p>Category: {{ $ticket->category->name }}</p>
                </div>
            </td>
        </tr>
        <tr>
            <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
        </tr>
        <tr>
            <td class="center-text" align="left"
                style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">

                <div>
                    <code>
                        {!! $ticket->message !!}
                    </code>
                </div>
            </td>
        </tr>
        <tr>
            <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
        </tr>

        @if ($role !== 'student')
            <tr>
                <td class="center-text" align="left"
                    style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:300;font-style:normal;text-decoration:none;letter-spacing:0px;">

                    <div>
                        <p>
                            <b>Created By:</b> {{ $ticket->user->name }} <br>
                            <b>Created At:</b> {{ $ticket->created_at->diffForHumans() }}
                        </p>
                    </div>
                </td>
            </tr>
            <tr>
                <td height="40" style="font-size:40px;line-height:40px;">&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                    <table border="0" cellspacing="0" cellpadding="0" role="presentation" align="left"
                        class="center-float">
                        <tr>
                            <td align="left" bgcolor="#d6df58" style="border-radius: 6px;">
                                <a href="{{ route('tickets.show', $ticket->slug) }}" target="_blank" class="main-btn"><span>View
                                        Ticket</span></a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endif
    </tr>
@endsection
