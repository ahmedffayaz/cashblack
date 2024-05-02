
<form action="{{route(getAdminPrefix() . '.email_templates.update',$template)}}" class="gy-3 form-validate is-alter template_form" method="POST">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="form-group">
                <label class="form-label" for="subject">Subject</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="subject" value="{{$template->subject}}" name="subject" required>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <label class="form-label" for="phone-no-1">Message</label>
                <p>Allowed tags: {{$template->keywords}}</p>
                <!-- Create the editor container -->
                <div  id="message" >
                    @php
                        $filteredMessage = $template->message;
                        $filteredMessage = str_replace('{{SITE_URL}}', url('/'), $filteredMessage);
                        echo $filteredMessage;
                    @endphp
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary">Save</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')

@endpush
