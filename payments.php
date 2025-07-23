<?php
session_start();
require_once 'includes/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}
$user_stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
$user_stmt->execute([$_SESSION['user_id']]);
$current_user = $user_stmt->fetch();
if (!$current_user || $current_user['role'] !== 'admin') {
    header('Location: home.php');
    exit;
}
$success = '';
$error = '';
// CREATE
if (isset($_POST['add_payment'])) {
    $ride_id = trim($_POST['ride_id']);
    $amount = trim($_POST['amount']);
    $payment_method = $_POST['payment_method'];
    $transaction_id = trim($_POST['transaction_id']);
    $status = $_POST['status'];
    // Validate ride_id exists
    $stmt = $pdo->prepare('SELECT * FROM rides WHERE ride_id = ?');
    $stmt->execute([$ride_id]);
    if (!$stmt->fetch()) {
        $error = 'Ride ID must exist.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO payments (ride_id, amount, payment_method, transaction_id, status, timestamp) VALUES (?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$ride_id, $amount, $payment_method, $transaction_id, $status]);
        $success = 'Payment added successfully!';
    }
}
// UPDATE
if (isset($_POST['edit_payment'])) {
    $edit_id = $_POST['edit_id'];
    $ride_id = trim($_POST['ride_id']);
    $amount = trim($_POST['amount']);
    $payment_method = $_POST['payment_method'];
    $transaction_id = trim($_POST['transaction_id']);
    $status = $_POST['status'];
    // Validate ride_id exists
    $stmt = $pdo->prepare('SELECT * FROM rides WHERE ride_id = ?');
    $stmt->execute([$ride_id]);
    if (!$stmt->fetch()) {
        $error = 'Ride ID must exist.';
    } else {
        $stmt = $pdo->prepare('UPDATE payments SET ride_id=?, amount=?, payment_method=?, transaction_id=?, status=? WHERE payment_id=?');
        $stmt->execute([$ride_id, $amount, $payment_method, $transaction_id, $status, $edit_id]);
        $success = 'Payment updated successfully!';
    }
}
// DELETE
if (isset($_POST['delete_payment'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $pdo->prepare('DELETE FROM payments WHERE payment_id = ?');
    $stmt->execute([$delete_id]);
    $success = 'Payment deleted successfully!';
}
// READ
$payments = $pdo->query('SELECT * FROM payments ORDER BY payment_id DESC')->fetchAll();
?>
<?php include 'header.php'; ?>
<div class="container" style="padding-top:120px;">
    <h2>Payments Management (Full CRUD)</h2>
    <?php if ($success): ?><div style="color:green;"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div style="color:red;"><?php echo $error; ?></div><?php endif; ?>
    <h3>Add Payment</h3>
    <form method="post" style="margin-bottom:30px;">
        <input type="number" name="ride_id" placeholder="Ride ID" required>
        <input type="number" step="0.01" name="amount" placeholder="Amount">
        <select name="payment_method" required>
            <option value="cash">Cash</option>
            <option value="card">Card</option>
            <option value="wallet">Wallet</option>
        </select>
        <input type="text" name="transaction_id" placeholder="Transaction ID">
        <select name="status" required>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="failed">Failed</option>
            <option value="refunded">Refunded</option>
        </select>
        <button type="submit" name="add_payment">Add Payment</button>
    </form>
    <h3>All Payments</h3>
    <table border="1" cellpadding="6" style="width:100%;background:#fff;">
        <tr>
            <th>ID</th><th>Ride ID</th><th>Amount</th><th>Method</th><th>Transaction</th><th>Status</th><th>Timestamp</th><th>Actions</th>
        </tr>
        <?php foreach ($payments as $p): ?>
        <tr>
            <td><?php echo $p['payment_id']; ?></td>
            <td><?php echo $p['ride_id']; ?></td>
            <td><?php echo $p['amount']; ?></td>
            <td><?php echo htmlspecialchars($p['payment_method']); ?></td>
            <td><?php echo htmlspecialchars($p['transaction_id']); ?></td>
            <td><?php echo htmlspecialchars($p['status']); ?></td>
            <td><?php echo htmlspecialchars($p['timestamp']); ?></td>
            <td>
                <button type="button" onclick="showEditForm(<?php echo $p['payment_id']; ?>, <?php echo $p['ride_id']; ?>, <?php echo $p['amount']; ?>, '<?php echo htmlspecialchars($p['payment_method'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($p['transaction_id'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($p['status'], ENT_QUOTES); ?>')">Edit</button>
                <form method="post" style="display:inline;" onsubmit="return confirm('Delete this payment?');">
                    <input type="hidden" name="delete_id" value="<?php echo $p['payment_id']; ?>">
                    <button type="submit" name="delete_payment">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div id="editPaymentModal" style="display:none;padding:20px;background:#f9f9f9;border:1px solid #ccc;margin-top:30px;">
        <h3>Edit Payment</h3>
        <form method="post">
            <input type="hidden" name="edit_id" id="edit_id">
            <input type="number" name="ride_id" id="edit_ride_id" placeholder="Ride ID" required>
            <input type="number" step="0.01" name="amount" id="edit_amount" placeholder="Amount">
            <select name="payment_method" id="edit_payment_method" required>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="wallet">Wallet</option>
            </select>
            <input type="text" name="transaction_id" id="edit_transaction_id" placeholder="Transaction ID">
            <select name="status" id="edit_status" required>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="failed">Failed</option>
                <option value="refunded">Refunded</option>
            </select>
            <button type="submit" name="edit_payment">Update Payment</button>
            <button type="button" onclick="document.getElementById('editPaymentModal').style.display='none';">Cancel</button>
        </form>
    </div>
</div>
<script>
function showEditForm(id, ride_id, amount, payment_method, transaction_id, status) {
    document.getElementById('editPaymentModal').style.display = 'block';
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_ride_id').value = ride_id;
    document.getElementById('edit_amount').value = amount;
    document.getElementById('edit_payment_method').value = payment_method;
    document.getElementById('edit_transaction_id').value = transaction_id;
    document.getElementById('edit_status').value = status;
    window.scrollTo(0, document.body.scrollHeight);
}
</script>
<?php include 'footer.php'; ?> 