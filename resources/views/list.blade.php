@extends(app('oxygen.layout'))

@section('content')

<?php

    use Oxygen\Core\Html\Header\Header;

    $header = Header::fromBlueprint(
        $blueprint,
        Lang::get('oxygen/mod-security::ui.title')
    );

?>

<div class="Block">
    {!! $header->render() !!}
</div>

<div class="Block">
    <?php
        $toolbarItem = $blueprint->getToolbarItem('getLoginLog');
        if($toolbarItem->shouldRender()):
    ?>
        <div class="Row--visual">
            <h2 class="heading-gamma">Login Log</h2>
            {!! $toolbarItem->render(['margin' => 'vertical']) !!}
            <p>
                Whenever users login to Oxygen, their IP address will be logged in this log. You can view this log to check for unusual login attempts.
            </p>
        </div>
    <?php
        endif;
    ?>
</div>

@stop
