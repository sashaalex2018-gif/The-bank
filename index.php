<?php
$type = $_POST['type'] ?? 'mortgage';

$rates = [
    'mortgage' => 9.6,
    'auto' => 3.5,
    'consumer' => 14.5
];

$names = [
    'mortgage' => 'Ипотека',
    'auto' => 'Автокредит',
    'consumer' => 'Потребительский'
];

$payment = $income = $overpay = $total = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cost = $_POST["cost"];
    $down = $_POST["down"];
    $years = $_POST["years"];

    $rate = $rates[$type];
    $amount = $cost - $down;
    $monthlyRate = ($rate / 100) / 12;
    $months = $years * 12;

    $factor = pow(1 + $monthlyRate, $months);
    $payment = $amount * $monthlyRate * $factor / ($factor - 1);
    $total = $payment * $months;
    $overpay = $total - $amount;
    $income = $payment * 2.5;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Bank Service</title>
<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    color:white;
    text-align:center;
}
.container {
    background:white;
    color:black;
    padding:25px;
    margin:60px auto;
    width:380px;
    border-radius:15px;
}
button {
    padding:10px;
    margin:5px;
    border:none;
    border-radius:5px;
    background:#2a5298;
    color:white;
}
input {
    margin:5px;
    padding:10px;
    width:90%;
}
.result {
    margin-top:15px;
    padding:10px;
    background:#f1f1f1;
    border-radius:10px;
}
</style>
</head>
<body>

<h1>Банковский калькулятор</h1>

<div class="container">
<form method="POST">
    <div>
        <button name="type" value="mortgage">Ипотека</button>
        <button name="type" value="auto">Авто</button>
        <button name="type" value="consumer">Потреб</button>
    </div>

    <input type="number" name="cost" placeholder="Стоимость" required>
    <input type="number" name="down" placeholder="Первоначальный взнос" required>
    <input type="number" name="years" placeholder="Срок (лет)" required>

    <button type="submit">Рассчитать</button>
</form>

<?php if ($payment): ?>
<div class="result">
    <h3><?php echo $names[$type]; ?></h3>
    <p>Платеж: <?php echo round($payment,2); ?></p>
    <p>Общая сумма: <?php echo round($total,2); ?></p>
    <p>Переплата: <?php echo round($overpay,2); ?></p>
    <p>Доход: <?php echo round($income,2); ?></p>
</div>
<?php endif; ?>

</div>

</body>
</html>
