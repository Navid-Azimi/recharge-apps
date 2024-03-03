@php
    if (!isset($actionBtnIcon)) {
        $actionBtnIcon = null;
    } else {
        $actionBtnIcon = $actionBtnIcon . ' fa-fw';
    }
    if (!isset($modalClass)) {
        $modalClass = null;
    }
    if (!isset($btnSubmitText)) {
        $btnSubmitText = trans('LaravelLogger::laravel-logger.modals.shared.btnConfirm');
    }
@endphp
<div class="modal fade modal-{{ $modalClass }}" id="{{ $formTrigger }}" role="dialog"
    aria-labelledby="{{ $formTrigger }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border bg-gray">
            <div class="modal-header {{ $modalClass }}">
                <h5 class="modal-title">
                    Confirm
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure?</p>
            </div>
            <div class="modal-footer bg-transparent border d-flex justify-content-between">
                {!! Form::button(
                    '<i class="fa fa-fw fa-close" aria-hidden="true"></i> ' .
                        trans('LaravelLogger::laravel-logger.modals.shared.btnCancel'),
                    ['class' => 'btn btn-outline pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal'],
                ) !!}
                {!! Form::button('<i class="fa ' . $actionBtnIcon . '" aria-hidden="true"></i> ' . $btnSubmitText, [
                    'class' => 'btn btn-' . $modalClass . ' pull-right btn-flat',
                    'type' => 'button',
                    'id' => 'confirm',
                ]) !!}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Confirm Form Submit Modal
    const confirmBtn = document.getElementById('confirm');

    $('{{ $formTrigger }}').on('show.bs.modal', function(e) {
        var message = $(e.relatedTarget).attr('data-message');
        var title = $(e.relatedTarget).attr('data-title');
        var form = $(e.relatedTarget).closest('form');
        $(this).find('.modal-body p').text(message);
        $(this).find('.modal-title').text(title);
        $(this).find('.modal-footer #confirm').data('form', form);
        console.log('frm submitted');
    });
    $('{{ $formTrigger }}').find('.modal-footer #confirm').on('click', function() {
        $(this).data('form').submit();
        console.log('Form submitted');
    });
</script>
