<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvestmentLoan $investmentLoan
 */

use Cake\Core\Configure;

$config = Configure::read('InvestmentLoan');

$minInterest = $config['interest']['min'];
$maxInterest = $config['interest']['max'];
$minDuration = $config['duration']['min'];
$maxDuration = $config['duration']['max'];
?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Wallets'), ['controller' => 'Wallets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Investment Loans'), ['action' => 'index']) ?></li>
    </ul>
</nav>

<div class="investments form large-9 medium-8 columns content">
    <?= $this->Form->create($investmentLoan) ?>

    <?= $this->Form->control('title', [
        'type' => 'text',
        'label' => __('Investment loan title'),
        'value' => $investmentLoan->title ?? '',
        'style' => 'width: 100%; margin-bottom: 1em;',
    ]) ?>

    <?= $this->Form->control('max_amount', [
        'type' => 'number',
        'step' => '0.01',
        'label' => __('Max amount'),
        'value' => $investmentLoan->max_amount ?? '',
        'style' => 'width: 100%; margin-bottom: 1em;',
    ]) ?>

    <fieldset>
        <legend><?= __('Interest Rate (%)') ?></legend>
        <div style="display:flex; gap: 20px; align-items: center;">

            <?= $this->Form->control('min_interest', [
                'type' => 'number',
                'min' => $minInterest,
                'max' => $maxInterest,
                'step' => 1,
                'label' => __('Min Interest'),
                'id' => 'min-interest-input',
                'value' => $investmentLoan->min_interest ?? $minInterest,
                'style' => 'width:80px;',
                'data-min' => $minInterest,
                'data-max' => $maxInterest,
            ]) ?>

            <input
                type="range"
                id="min-interest-range"
                min="<?= $minInterest ?>"
                max="<?= $maxInterest ?>"
                step="1"
                value="<?= $investmentLoan->min_interest ?? $minInterest ?>"
                style="flex-grow:1;"
            />

            <?= $this->Form->control('max_interest', [
                'type' => 'number',
                'min' => $minInterest,
                'max' => $maxInterest,
                'step' => 1,
                'label' => __('Max Interest'),
                'id' => 'max-interest-input',
                'value' => $investmentLoan->max_interest ?? $maxInterest,
                'style' => 'width:80px;',
                'data-min' => $minInterest,
                'data-max' => $maxInterest,
            ]) ?>

            <input
                type="range"
                id="max-interest-range"
                min="<?= $minInterest ?>"
                max="<?= $maxInterest ?>"
                step="1"
                value="<?= $investmentLoan->max_interest ?? $maxInterest ?>"
                style="flex-grow:1;"
            />

        </div>
    </fieldset>

    <fieldset>
        <legend><?= __('Duration (months)') ?></legend>
        <div style="display:flex; gap: 20px; align-items: center;">

            <?= $this->Form->control('min_duration_months', [
                'type' => 'number',
                'min' => $minDuration,
                'max' => $maxDuration,
                'step' => 1,
                'label' => __('Min Duration'),
                'id' => 'min-duration-input',
                'value' => $investmentLoan->min_duration_months ?? $minDuration,
                'style' => 'width:80px;',
                'data-min' => $minDuration,
                'data-max' => $maxDuration,
            ]) ?>

            <input
                type="range"
                id="min-duration-range"
                min="<?= $minDuration ?>"
                max="<?= $maxDuration ?>"
                step="1"
                value="<?= $investmentLoan->min_duration_months ?? $minDuration ?>"
                style="flex-grow:1;"
            />

            <?= $this->Form->control('max_duration_months', [
                'type' => 'number',
                'min' => $minDuration,
                'max' => $maxDuration,
                'step' => 1,
                'label' => __('Max Duration'),
                'id' => 'max-duration-input',
                'value' => $investmentLoan->max_duration_months ?? $maxDuration,
                'style' => 'width:80px;',
                'data-min' => $minDuration,
                'data-max' => $maxDuration,
            ]) ?>

            <input
                type="range"
                id="max-duration-range"
                min="<?= $minDuration ?>"
                max="<?= $maxDuration ?>"
                step="1"
                value="<?= $investmentLoan->max_duration_months ?? $maxDuration ?>"
                style="flex-grow:1;"
            />

        </div>
    </fieldset>

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bindSync = (inputId, rangeId) => {
            const input = document.getElementById(inputId);
            const range = document.getElementById(rangeId);
            const min = parseInt(input.dataset.min);
            const max = parseInt(input.dataset.max);

            input.addEventListener('input', () => {
                let val = parseInt(input.value) || min;
                if (val < min) val = min;
                if (val > max) val = max;
                input.value = val;
                range.value = val;
            });

            range.addEventListener('input', () => {
                input.value = range.value;
            });
        };

        bindSync('min-interest-input', 'min-interest-range');
        bindSync('max-interest-input', 'max-interest-range');
        bindSync('min-duration-input', 'min-duration-range');
        bindSync('max-duration-input', 'max-duration-range');
    });
</script>
