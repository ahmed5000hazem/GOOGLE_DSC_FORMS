<header class="bg-primary text-light rounded my-3 p-3">
    <p class="text-center fs-1"> {{$form->name}} </p>
    <div class="row">
        @if ($form->expires_at && strtotime($form->expires_at) < time())
            <div class="col-lg-3">
                <p class="fs-4 text-warning"> <strong> Form Expired </strong></p>
            </div>
        @else
            <div class="col-lg-3">
                <p class="fs-4"> {{$form->expires_at?"available untill ".$form->expires_at : "available forever"}} </p>
            </div>
            <div class="col-lg-3">
                <p class="fs-4">Questions: {{count($questions)}}</p>
            </div>
        @endif
    </div>
</header>