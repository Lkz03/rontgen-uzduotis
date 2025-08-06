<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvestmentLoan[]|\Cake\Collection\CollectionInterface $investmentLoans
 */
?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Wallets'), ['controller' => 'Wallets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Investment Loan'), ['action' => 'add']) ?></li>
    </ul>
</nav>

<div class="investments index large-9 medium-8 columns content">
    <h3><?= __('Investment Projects') ?></h3>

    <div class="investment-list">
        <?php foreach ($investmentLoans as $loan): ?>
            <div class="investment-item">
                <div class="investment-header">
                    <strong><?= h($loan->title) ?></strong>
                </div>

                <div class="investment-progress">
                    <?php
                    $progress = $loan->current_amount && $loan->max_amount
                        ? min(100, round(($loan->current_amount / $loan->max_amount) * 100))
                        : 0;
                    ?>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= $progress ?>%;">
                            <?= $progress ?>%
                        </div>
                    </div>
                    <div class="investment-amount">
                        <?= number_format($loan->max_amount, 2) ?>
                        <span class="arrow">&#9660;</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .investment-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .investment-item {
        border: 1px solid #ccc;
        padding: 1em;
        border-radius: 5px;
        background: #f9f9f9;
    }

    .investment-header {
        margin-bottom: 0.5em;
        font-size: 1.1em;
    }

    .investment-progress {
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

    .investment-amount {
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
