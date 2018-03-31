<h1>Upload entry</h1>
{!! form_start($form) !!}
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_row($form->reload_on_change) !!}
        @if (is_object($form->getModel()))
            {!! form_label($form->competition_id) !!}
            <p>
                {{$record->competition->name}}
            </p>
        @else
            {!! form_row($form->competition_id) !!}
        @endif

        @if (Illuminate\Support\Facades\Input::old('competition_id') || (is_object($form->getModel()) && $form->getModel()->competition_id > 0))
            {!! form_row($form->author) !!}
            {!! form_row($form->title) !!}
        @endif
    </div>
    <!-- /.box-body -->
</div>
@if (Illuminate\Support\Facades\Input::old('competition_id') || (is_object($form->getModel()) && $form->getModel()->competition_id > 0))
    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.entry_info') }}</h3>
        </div>
        <div class="@boxBody">
            {!! form_row($form->description) !!}
            {!! form_row($form->organizer_description) !!}
            @if ($form->has('running_time'))
                {!! form_row($form->running_time) !!}
            @endif
        </div>
        <!-- /.box-body -->
    </div>
    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.option_info') }}</h3>
        </div>
        <div class="@boxBody">
            {!! form_row($form->options) !!}
            {!! form_row($form->custom_option) !!}
        </div>
        <!-- /.box-body -->
    </div>

    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.file_info') }}</h3>
        </div>
        <div class="@boxBody">
            <div class="row">
                @if ($form->has('screenshot'))
                    <div class="col-md-3">
                        {!! form_row($form->screenshot) !!}
                    </div>
                @endif
                @if ($form->has('audio'))
                    <div class="col-md-3">
                        {!! form_row($form->audio) !!}
                    </div>
                @endif
                @if ($form->has('video'))
                    <div class="col-md-3">
                        {!! form_row($form->video) !!}
                    </div>
                @endif
            </div>

            @if ($form->has('work_stage_1'))
                <div class="row">

                    @php
                        $i = 1;
                    @endphp
                    @while ($form->has('work_stage_'.$i))
                        <div class="col-md-6">
                            {!! form_row($form->{'work_stage_'.$i}) !!}
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endwhile
                </div>
            @endif

            {!! form_row($form->file) !!}
        </div>
        <!-- /.box-body -->
    </div>
    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.author_info') }}</h3>
        </div>
        <div class="@boxBody">
            {!! form_row($form->author_name) !!}
            {!! form_row($form->author_email) !!}
            {!! form_row($form->author_phone) !!}
            {!! form_row($form->author_address) !!}
            {!! form_row($form->author_zip) !!}
            {!! form_row($form->author_city) !!}
            {!! form_row($form->author_country_iso_3166_1) !!}
        </div>
        <!-- /.box-body -->
    </div>
    @if ($form->has('composer_name'))
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">
                    <button type="button" class="btn btn-sm btn-success float-right copy-data">Copy author data</button>
                    {{ trans('partymeister-competitions::backend/entries.composer_info') }}
                </h3>
            </div>
            <div class="@boxBody">
                {!! form_row($form->composer_name) !!}
                {!! form_row($form->composer_email) !!}
                {!! form_row($form->composer_phone) !!}
                {!! form_row($form->composer_address) !!}
                {!! form_row($form->composer_zip) !!}
                {!! form_row($form->composer_city) !!}
                {!! form_row($form->composer_country_iso_3166_1) !!}
            </div>
            <!-- /.box-body -->
        </div>
    @endif
    <div class="@boxWrapper">
        <div class="@boxFooter">
            {!! form_row($form->submit) !!}
        </div>
    </div>

@endif
{!! form_end($form, false) !!}
@section('view_scripts')
    <script type="text/javascript">
        $('.reload-on-change').change(function (e) {
            $('#reload_on_change').val(1);
            $(this).closest('form').submit();
        });
        $('#reload_on_change').val('');

        $('.copy-data').on('click', function (e) {
            e.preventDefault();
            $('input#composer_name').val($('input#author_name').val());
            $('input#composer_email').val($('input#author_email').val());
            $('input#composer_phone').val($('input#author_phone').val());
            $('input#composer_address').val($('input#author_address').val());
            $('input#composer_zip').val($('input#author_zip').val());
            $('input#composer_city').val($('input#author_city').val());
            $('input#composer_country_iso_3166_1').val($('input#author_country_iso_3166_1').val());
        });

        $("input").keypress(function (e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });
    </script>
@append
