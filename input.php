<!-- input.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Dental Invoice Generator</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        td, th { border: 1px solid #ccc; padding: 8px; text-align: left; }
        h2 { text-align: center; }
        .btn { padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>
    <form action="generate_invoice.php" method="post">
        <h2>INVOICE</h2>

        <div style="display: flex; justify-content: space-between;">
            <div>
                <h3>Clinic Details</h3>
                Clinic Name: <input type="text" name="clinic_name" required><br>
                Address: <input type="text" name="clinic_address" required><br>
            </div>
            <div>
                <h3>Invoice Details</h3>
                Invoice No: <input type="text" name="invoice_no" required><br>
                Date: <input type="date" name="invoice_date" required><br>
            </div>
        </div>

        <h3>Patient Information</h3>
        Name: <input type="text" name="patient_name" required><br>
        Address: <input type="text" name="patient_address"><br>
        Age: <input type="text" name="patient_age"><br>
        Phone: <input type="text" name="patient_phone"><br>

        <h3>Treatment Details</h3>
        <table id="treatmentTable">
            <thead>
                <tr>
                    <th>Treatment</th>
                    <th>Date</th>
                    <th>Cost</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="rows">
                <!-- dynamic rows go here -->
            </tbody>
        </table>
        <button type="button" class="btn" onclick="addRow()">Add Treatment</button>
        <br><br>

        <h3>Receipt Summary</h3>
        Patient Name: <input type="text" name="receipt_name" required><br>
        Receipt Date: <input type="date" name="receipt_date" required><br>

        <input type="hidden" name="doctor_name" value="Dr Rahul Kalra">
        <input type="hidden" name="clinic_sign" value="Spring Dental (SpringUp Healthcare Private Limited)">

        <br>
        <input type="submit" value="Generate Invoice PDF">
    </form>

    <script>
        const treatments = ["Root Canal", "Implant", "GIC", "Composite", "Crown"];
        function addRow() {
            const table = document.getElementById('rows');
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>
                    <select name="treatment_name[]">
                        ${treatments.map(t => `<option value="${t}">${t}</option>`).join('')}
                    </select>
                </td>
                <td><input type="date" name="treatment_date[]" required></td>
                <td><input type="number" name="cost[]" step="0.01" required onchange="calculateAmount(this)"></td>
                <td><input type="number" name="qty[]" required onchange="calculateAmount(this)"></td>
                <td><input type="text" name="amount[]" readonly></td>
                <td><button type="button" onclick="this.parentElement.parentElement.remove()">Delete</button></td>
            `;
            table.appendChild(row);
        }

        function calculateAmount(elem) {
            const row = elem.closest("tr");
            const cost = parseFloat(row.querySelector('[name="cost[]"]').value) || 0;
            const qty = parseFloat(row.querySelector('[name="qty[]"]').value) || 0;
            row.querySelector('[name="amount[]"]').value = (cost * qty).toFixed(2);
        }
    </script>
</body>
</html>
