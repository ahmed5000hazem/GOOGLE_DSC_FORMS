<header class="bg-primary text-light rounded my-3 p-3">
    <p class="text-center fs-1"> {{$form->name}} </p>
    @if ($form->expires_at && strtotime($form->expires_at) < time())
        <div class="row">
            <div class="col-lg-3">
                <p class="fs-4 text-warning"> <strong> Form Expired </strong></p>
            </div>
        </div>
        @else
        <div class="row justify-content-center">
            <div class="col-8 col-lg-6">
                <p> {{$form->description}} </p>
            </div>
            <hr>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <p class="fs-4"> {{$form->expires_at?"available untill ".$form->expires_at : "available forever"}} </p>
            </div>
            <div class="col-lg-3">
                <p class="fs-4">Questions: {{count($questions) - count($hidden_questions)}}</p>
            </div>
        </div>
    @endif
</header>