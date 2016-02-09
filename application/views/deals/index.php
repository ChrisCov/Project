<?php if ($numproducts > 0): ?>
<div id="data-holder">
    <div id="data-header">
        <H1><?= sprintf(__("Top %d of %s"), $numproducts, $filter_name) ?></H1>
    </div>
    <?php foreach ($products as $product): ?>
    <div class="data-item">
        <div class="data-item-content">
        <b>Product name: </b> <?= strtr($product->title, array ('Â' => '')) ?><BR />
        <b>Temperature: </b> <?= $product->temperature ?><BR />
        <b>Price: </b> <?= ($product->price) != null ? number_format($product->price, 2, '.', ' ') . ' GBP' : 'unknown'  ?> <BR />
        <b>Date: </b> <?= date('Y-m-d H:i', $product->timestamp) ?> <BR />
        <b>URL of product: </b> <?= HTML::anchor($product->display_page_url, $product->display_page_url) ?> <BR />
        <b>URL of deal: </b> <?= HTML::anchor($product->deal_link, $product->deal_link) ?><BR />
        <b>Description: </b> <?= strtr($product->description, array ('Â' => '', 'â' => '', '¢' => '')) ?><BR />
        </div>
        <div class="data-item-image">
        <?= HTML::image($product->deal_image, array('alt' => 'thumbnail image is not available')) ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div id="allert-holder">
    <H1><?= __('Nothing found!') ?></H1>
</div>
<?php endif; ?>
<div style="clear: both">
<BR />
<?= HTML::anchor('/', 'Return to search page') ?>
</div>