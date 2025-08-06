<?php
require __DIR__ . '/vendor/autoload.php'; // mpdf autoload

use Mpdf\Mpdf;

$mpdf = new Mpdf();

ob_start();
?>

<h1 style="text-align:center;">INVOICE</h1>

<table width="100%">
    <tr>
        <td>
            <strong>Clinic Name:</strong> <?= $_POST['clinic_name'] ?><br>
            <strong>Address:</strong> <?= $_POST['clinic_address'] ?>
        </td>
        <td align="right">
            <strong>Invoice No:</strong> <?= $_POST['invoice_no'] ?><br>
            <strong>Date:</strong> <?= $_POST['invoice_date'] ?>
        </td>
    </tr>
</table>

<hr>

<h3>Patient Details</h3>
<table>
    <tr><td>Name:</td><td><?= $_POST['patient_name'] ?></td></tr>
    <tr><td>Address:</td><td><?= $_POST['patient_address'] ?></td></tr>
    <tr><td>Age:</td><td><?= $_POST['patient_age'] ?></td></tr>
    <tr><td>Phone:</td><td><?= $_POST['patient_phone'] ?></td></tr>
</table>

<h3>Treatment Details</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Treatment</th><th>Date</th><th>Cost</th><th>Qty</th><th>Amount</th>
    </tr>
    <?php
    $total = 0;
    foreach ($_POST['treatment_name'] as $i => $treat) {
        $cost = $_POST['cost'][$i];
        $qty = $_POST['qty'][$i];
        $amount = $cost * $qty;
        $total += $amount;
        echo "<tr>
                <td>{$treat}</td>
                <td>{$_POST['treatment_date'][$i]}</td>
                <td>{$cost}</td>
                <td>{$qty}</td>
                <td>" . number_format($amount, 2) . "</td>
              </tr>";
    }
    ?>
    <tr>
        <td colspan="4" align="right"><strong>Total</strong></td>
        <td><strong><?= number_format($total, 2) ?></strong></td>
    </tr>
</table>

<h3>Receipt</h3>
<p>
    Received from <strong><?= $_POST['receipt_name'] ?></strong> an amount of 
    <strong>₹<?= number_format($total, 2) ?></strong> on 
    <strong><?= $_POST['receipt_date'] ?></strong>
</p>

<br><br><br>
<table width="100%">
    <tr>
        <td>
            <strong><?= $_POST['doctor_name'] ?></strong><br>
            <?= $_POST['clinic_sign'] ?><br>
            <i>Signature & Stamp</i>
        </td>
    </tr>
</table>

<?php
$html = ob_get_clean();
$mpdf->WriteHTML($html);
$mpdf->Output('invoice.pdf', 'I'); // 'I' = inline, use 'D' for download
