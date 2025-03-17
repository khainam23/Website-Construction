@if ($errors->any())
    <div class="alert alert-danger">
        <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
        <div class="bg-red alert-icon">
            <i class="glyph-icon icon-times"></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">{{ __('Error') }}</h4>
            <strong>{{ __('Notification') }}:</strong>{{ __('Please check the data again') }}
        </div>
    </div>

@endif

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
        <div class="bg-green alert-icon">
            <i class="glyph-icon icon-check"></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">{{ __('Success') }}</h4>
            <strong>{{ __('Notification') }}:</strong> {{ $message }}
        </div>
    </div>

@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger">
        <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
        <div class="bg-red alert-icon">
            <i class="glyph-icon icon-times"></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">{{ __('Error') }}</h4>
            <strong>{{ __('Notification') }}:</strong> {{ $message }}
        </div>
    </div>

@endif

@if ($message = Session::get('failed'))
    <div class="alert alert-danger">
        <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
        <div class="bg-red alert-icon">
            <i class="glyph-icon icon-times"></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">{{ __('Error') }}</h4>
            <strong>{{ __('Notification') }}:</strong> {{ $message }}
        </div>
    </div>

@endif
@if ($message = Session::get('warning'))
    <div class="alert alert-warning">
        <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
        <div class="bg-orange alert-icon">
            <i class="glyph-icon icon-warning"></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">{{ __('Warning') }}</h4>
            <strong>{{ __('Notification') }}:</strong> {{ $message }}
        </div>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-notice">
        <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
        <div class="bg-blue alert-icon">
            <i class="glyph-icon icon-info"></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">{{ __('Notification') }}</h4>
            <strong>{{ __('Notification') }}:</strong> {{ $message }}
        </div>
    </div>
@endif
@if ($message = Session::get('msg'))
    <div class="alert alert-danger alert-dismissable margin5">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>{{ __('Notification') }}:</strong> {{ $message }}
    </div>
@endif
