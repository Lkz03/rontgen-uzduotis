<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mano Paskolos Prašymai</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
            padding: 2rem;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
        }
        .loan-request-card {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
        .request-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            border-bottom: 1px solid #ddd;
            padding-bottom: 1rem;
        }
        .request-info h3 {
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        .request-info p {
            margin: 0;
            color: #555;
        }
        .matching-loans {
            margin-top: 1rem;
        }
        .matching-loans h4 {
            color: #764ba2;
            margin-bottom: 1rem;
            border-left: 3px solid #764ba2;
            padding-left: 0.5rem;
        }
        .loan-list {
            list-style: none;
            padding: 0;
        }
        .loan-item {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .loan-item-details p {
            margin: 0;
            line-height: 1.5;
        }
        .loan-item-details strong {
            color: #444;
        }
        .no-requests, .no-loans {
            text-align: center;
            color: #888;
            padding: 2rem;
        }
        .request-details {
            align-items: flex-start; 
        }
        .request-date {
            text-align: right;
        }
        .delete-btn {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            display: inline-block;
        }
        .delete-btn:hover {
            background: #e60000;
            transform: translateY(-1px);
        }
        .button-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        .add-button {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .add-button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mano Paskolos Prašymai</h1>
        <div class="button-container">
            <?= $this->Html->link('Pridėti naują prašymą', ['action' => 'request'], ['class' => 'add-button']) ?>
        </div>
        <?php if (!empty($loanRequests)): ?>
            <?php foreach ($loanRequests as $request): ?>
                <div class="loan-request-card">
                    <div class="request-details">
                        <div class="request-info">
                            <h3>Prašymas #<?= h($request->id) ?></h3>
                            <p><strong>Prašoma suma:</strong> <?= h($this->Number->currency($request->amount, 'EUR')) ?></p>
                            <p><strong>Trukmė:</strong> <?= h($request->duration) ?> mėn.</p>
                        </div>
                        <div class="request-date">
                            <p>Pateikta: <?= h($request->created->format('Y-m-d H:i')) ?></p>
                            <?= $this->Form->postLink(
                                __('Ištrinti'),
                                ['action' => 'delete', $request->id],
                                ['confirm' => 'Ar tikrai norite ištrinti šį paskolos prašymą?', 'class' => 'delete-btn']
                            ) ?>
                        </div>
                    </div>

                    <div class="matching-loans">
                        <h4>Atitinkančios paskolos:</h4>
                        <?php if (!empty($matchingLoans[$request->id])): ?>
                            <ul class="loan-list">
                                <?php foreach ($matchingLoans[$request->id] as $loan): ?>
                                    <li class="loan-item">
                                        <div class="loan-item-details">
                                            <p><strong>Paskolos pavadinimas:</strong> <?= h($loan->title) ?></p>
                                            <?php
                                                $ratio = 0;
                                                if ($loan->max_duration_months != $loan->min_duration_months) {
                                                    $ratio = ($request->duration - $loan->min_duration_months) / ($loan->max_duration_months - $loan->min_duration_months);
                                                    $ratio = max(0, min(1, $ratio));
                                                }
                                                $effectiveInterest = $loan->min_interest + ($loan->max_interest - $loan->min_interest) * $ratio;
                                            ?>
                                            <p><strong>Palūkanos:</strong> <?= h(number_format($effectiveInterest, 2)) ?>%</p>
                                        </div>
                                        <div>
                                            <button 
                                                class="add-button" 
                                                onclick="requestLoan(<?= h($request->id) ?>, <?= h($loan->id) ?>)">
                                                Request
                                            </button>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="no-loans">Nėra atitinkančių paskolų šiam prašymui.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-requests">Jūs dar neturite pateiktų paskolos prašymų.</p>
        <?php endif; ?>
    </div>

    <script>
        function requestLoan(requestId, loanId) {
            if (confirm("Ar tikrai norite pateikti paskolos prašymą?")) {
                const url = `/loan-applications/request-loan/${requestId}/${loanId}`;
                window.location.href = url;
            }
        }
    </script>
</body>
</html>
