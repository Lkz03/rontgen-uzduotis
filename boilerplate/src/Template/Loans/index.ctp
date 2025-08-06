<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Loan[]|\Cake\Collection\CollectionInterface $loans
 */
?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Wallets'), ['controller' => 'Wallets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Loan'), ['action' => 'add']) ?></li>
    </ul>
</nav>

<div class="loans index large-9 medium-8 columns content">
    <h3><?= __('Loans') ?></h3>

    <div class="loan-list">
        <?php foreach ($loans as $loan): ?>
            <div class="loan-item">
                <div class="loan-header">
                    <strong><?= h($loan->title) ?></strong>
                </div>

                <div class="loan-progress">
                    <?php
                    $progress = 1 && $loan->max_amount
                        ? min(100, round((0 / $loan->max_amount) * 100))
                        : 0;
                    ?>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= $progress ?>%;">
                            <?= $progress ?>%
                        </div>
                    </div>
                    <div class="loan-amount">
                        <?= number_format($loan->max_amount, 2) ?>
                        <span class="arrow">&#9660;</span>
                    </div>
                </div>
            </div>

            <div class="loan-item-actions">
                <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $loan->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $loan->id), 'class' => 'button danger']
                ) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .loan-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .loan-item {
        border: 1px solid #ccc;
        padding: 1em;
        border-radius: 5px;
        background: #f9f9f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .loan-header {
        margin-bottom: 0.5em;
        font-size: 1.1em;
    }

    .loan-progress {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .progress-bar {
        position: relative;
        flex-grow: 1;
        background: #e0e0e0;
        border-radius: 4px;
        overflow: hidden;
        height: 24px;
    }

    .progress-fill {
        background: #4caf50;
        height: 100%;
        color: white;
        text-align: center;
        line-height: 24px;
        white-space: nowrap;
        transition: width 0.3s ease-in-out;
    }

    .loan-amount {
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .arrow {
        font-size: 1.2em;
        color: #777;
    }
</style>