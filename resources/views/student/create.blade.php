@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="row">
            <div class="col-md-6">

                <h3>Add new Contact</h3>

                <div class="card">
                    <div class="card-body">

                        {{ Form::open(['url' => route('contact.store'),
			               'data-method' => 'POST',
				           'id' => 'ajax-form',
				           'files' => true,
				           'data-redirect' => route('home')
				         ]) }}

                        <div class="form-group" id="wrapper_name">
                            {{ Form::label('name'), ['class' => 'control-label mb-10 text-left'] }}
                            {{ Form::text('name',  null,  ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group" id="wrapper_number">
                            {{ Form::label('number'), ['class' => 'control-label mb-10 text-left'] }}
                            {{ Form::text('number',  null,  ['class' => 'form-control']) }}
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary"> Save</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">

        $(document).ready(function () {

            let ajaxForm = $('#ajax-form'), submitBtn, formData = new FormData(), redirectTo = '';
            if (ajaxForm.length > 0) {

                submitBtn = ajaxForm.find('button[type="submit"]');

                $('body').on('submit', '#ajax-form', function (e) {
                    e.preventDefault();
                    submitBtn.html("Saving... <i class=\"fa fa-cog fa-spin fa-ax fa-fw\"></i>");
                    submitBtn.attr('disabled', 'disabled');
                    formData.append('form-data', $(this).serialize());
                    redirectTo = $(this).data('redirect');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: $(this).data('method'),
                        url: $(this).attr('action'),
                        data: formData,
                        context: this,
                        dataType: 'json',
                        success: function (response) {
                            submitBtn.html("Save");
                            submitBtn.removeAttr('disabled');
                            if (response.status === false) {
                                // resetFile();
                                //   formData.set('files[]', null);
                                let errors = response.errors, elem;
                                $('p.error').remove();
                                errors.forEach((res) => {

                                    let ar = res.key.split('.');

                                    if (ar.length > 0) {
                                        elem = $('#wrapper_' + ar[0]);
                                    } else {
                                        elem = $('#wrapper_' + res.key);
                                    }
                                    if (elem && elem.length > 0) {
                                        $(elem).children('p').remove();
                                        $("<p class='error'>" + res.error + "</p>").appendTo(elem);
                                    }

                                });
                            } else {

                                window.location.href = redirectTo;
                            }
                        },
                        complete: function () {
                            $(this).data('requestRunning', false);
                        },
                        processData: false,
                        contentType: false,
                    });
                });
            }
        });

    </script>

@endsection
