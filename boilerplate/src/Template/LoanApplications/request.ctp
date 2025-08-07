<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Loan $loan
 */

use Cake\Core\Configure;

$config = Configure::read('InvestmentLoan');

$minDuration = $config['duration']['min'];
$maxDuration = $config['duration']['max'];
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paskolos Prašymas</title>
    <style>
        /* General styles from the example */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            width: auto;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logout-btn {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #ff5252;
            transform: translateY(-1px);
        }

        .container {
            max-width: 600px; /* Adjusted for form content */
            margin: 2rem auto;
            padding: 0 2rem;
            flex-grow: 1; /* Allows container to take up available space */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center content vertically */
        }

        /* Form specific styles */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-card h2 {
            margin-bottom: 1.5rem;
            color: #333;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #555;
        }

        .form-group input[type="number"] {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            color: #333;
            transition: border-color 0.3s ease;
        }

        .form-group input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 250px;
            margin-top: 1rem;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }

            .header {
                padding: 1rem;
            }

            .form-card {
                padding: 1.5rem;
            }

            .form-card h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h2>Paskolos Prašymas</h2>
            <div class="form-group">
                <?= $this->Form->create($loanRequest) ?>

                    <label for="amount">Prašoma suma (€)</label>
                    <?= $this->Form->control('amount', [
                        'type' => 'number',
                        'step' => '0.01',
                        'min' => '0',
                        'placeholder' => 'Įveskite sumą',
                        'required' => true,
                        'label' => false
                    ]) ?>

                    <fieldset>
                        <legend style="text-align: left; margin-bottom: 0.5rem; font-weight: 600; color: #555;">Trukmė (mėnesiais)</legend>
                        <div class="range-group">
                            <?= $this->Form->control('duration', [
                                'type' => 'number',
                                'min' => $minDuration,
                                'max' => $maxDuration,
                                'step' => 1,
                                'label' => false,
                                'id' => 'duration-input',
                                'value' => $loanRequest->duration ?? $minDuration,
                                'class' => 'input-number-small',
                                'data-min' => $minDuration,
                                'data-max' => $maxDuration,
                            ]) ?>

                            <input
                                type="range"
                                id="duration-range"
                                min="<?= $minDuration ?>"
                                max="<?= $maxDuration ?>"
                                step="1"
                                value="<?= $loanRequest->duration ?? $minDuration ?>"
                            />
                        </div>
                    </fieldset>

                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
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

            bindSync('duration-input', 'duration-range');
        });
    </script>
</body>
</html>