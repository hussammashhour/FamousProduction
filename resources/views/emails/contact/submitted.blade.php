@component('mail::message')
# New Contact Form Submission

**Name:** {{ $data['name'] }}
**Email:** {{ $data['email'] }}
@if(!empty($data['phone']))
**Phone:** {{ $data['phone'] }}
@endif
**Message Type:** {{ ucfirst($data['messageType']) }}
@if(!empty($data['interest']))
**Interests:** {{ implode(', ', $data['interest']) }}
@endif

---

**Message:**

{{ $data['message'] }}

@endcomponent
