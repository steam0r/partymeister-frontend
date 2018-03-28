{!! form_start($form) !!}
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="@boxBody">
        {{$record->title}} by {{$record->author}}
    </div>
    <!-- /.box-body -->
</div>
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.file_info') }}</h3>
    </div>
    <div class="@boxBody">
        @if ($form->has('screenshot'))
            {!! form_row($form->screenshot) !!}
        @endif
    </div>
    <div class="@boxFooter">
        {!! form_row($form->submit) !!}
    </div>
    <!-- /.box-body -->
</div>
{!! form_end($form, false) !!}
