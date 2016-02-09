<div id="content-header">
    <H1><?= __('Type merchant name and select results per page') ?></H1>
</div>
<div id="search-form-holder">
    <?= Form::open() ?>
    <div class="form-label">
        <label><?= __('Merchant') ?></label>
    </div>
    <div class="form-field">
        <?= Form::input('merchant') ?>
        <span style="color: red"><?= isset($error['merchant']) ? $error['merchant'] : '' ?></span>
    </div>
    <div style="clear: both"></div>
    <div class="form-label">
        <label><?= __('Results per page') ?></label>
    </div>
    <div class="form-field">
        <?= Form::select("results_per_page", array("0" => "10", "1" => "20", "2" => "30", "3" => "50")) ?>
    </div>
    <div style="clear: both"></div>
    <?= Form::submit('find', 'Find', array('id' => 'form-submit')) ?>
    <?= Form::close() ?>
</div>