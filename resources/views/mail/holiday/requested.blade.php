@component('mail::message')
# Dear Management

This letter is a formal request for a(n) {{$data['type']}} leave <br/>
from  {{date("F j, Y",strtotime($data['start_date']))}}
to {{date("F j, Y",strtotime($data['end_date']))}}.

{{ucfirst($data['description'])}} .

<br/><br/>
Thank you for reviewing my request!

@component('mail::button', ['url' =>$approve_url ,'color'=>'green'])
    Approve
@endcomponent

@component('mail::button', ['url' => $decline_url,'color'=>'red'])
    Decline&nbsp;
@endcomponent

Regards,<br>
{{ $user->name }}
@endcomponent
