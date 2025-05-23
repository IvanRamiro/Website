<?php include 'header.php'; ?>
<?php include 'config.php'; ?>

<style>
    :root {
        --primary: #34344A;
        --primary2: #9297C4;
        --secondary: #ffbd42;
        --secondary2: #EE5622;
        --white: #fff;
        --gray: #f5f5f5;
        --black1: #222;
        --black2: #666;
        
        --pending: #f6c23e;
        --approved: #1cc88a;
        --rejected: #e74a3b;
        
        --spacing-sm: 8px;
        --spacing-md: 16px;
        --spacing-lg: 24px;
        
        --font-sm: 0.9rem;
        --font-md: 1.1rem;
        --font-lg: 1.4rem;
        
        --transition-fast: 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        --transition-medium: 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        --transition-slow: 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        
        --radius: 12px;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .dashboard-container {
        position: relative;
        width: 100%;
        padding: var(--spacing-lg);
        display: grid;
        grid-template-columns: 2fr 1fr;
        grid-gap: var(--spacing-lg);
    }

    .loan-table-section {
        position: relative;
        background: var(--white);
        padding: var(--spacing-lg);
        border-radius: var(--radius);
        box-shadow: var(--card-shadow);
        animation: slideIn var(--transition-slow) both;
    }

    .stats-section {
        display: grid;
        grid-template-columns: 1fr;
        grid-gap: var(--spacing-lg);
        align-content: start;
    }

    .stat-card {
        background: var(--white);
        padding: var(--spacing-lg);
        border-radius: var(--radius);
        box-shadow: var(--card-shadow);
        transition: all var(--transition-medium);
        border-left: 4px solid var(--primary);
        cursor: pointer;
    }

    .stat-card:hover {
        background: var(--secondary2);
        transform: translateY(-5px);
        box-shadow: 0 var(--spacing-md) 30px rgba(0, 0, 0, 0.15);
    }

    .stat-card:hover .numbers,
    .stat-card:hover .cardName,
    .stat-card:hover .iconBx,
    .stat-card:hover .card-title,
    .stat-card:hover .card-value,
    .stat-card:hover .card-footer {
        color: var(--white);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-md);
    }

    .card-title {
        color: var(--black1);
        font-size: var(--font-md);
        font-weight: 500;
        text-transform: uppercase;
    }

    .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--white);
        background: var(--primary);
    }

    .card-value {
        font-weight: 600;
        font-size: var(--font-lg);
        color: var(--primary);
        margin: var(--spacing-sm) 0;
    }

    .card-footer {
        color: var(--black2);
        font-size: var(--font-sm);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-lg);
    }

    .section-title {
        font-weight: 600;
        color: var(--primary);
        background: rgba(77, 35, 121, 0.1);
        padding: var(--spacing-sm) var(--spacing-md);
        border-radius: var(--radius);
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        max-height: 70vh;
        margin-top: var(--spacing-md);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: var(--font-sm);
    }

    th {
        background: var(--secondary2);
        color: var(--white);
        padding: var(--spacing-md);
        text-align: left;
        position: sticky;
        top: 0;
        font-weight: 500;
    }

    td {
        padding: var(--spacing-md);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        color: var(--black1);
    }

    tr.loan-divider {
        border-top: 2px solid var(--primary);
    }

    tr:last-child {
        border-bottom: none;
    }
    
    tr:hover {
        background: var(--secondary2);
        color: var(--white);
    }
    

    tr:hover td {
        color: var(--white);
        background-color: var(--secondary2);
    }
    
    .badge {
        padding: 2px 8px;
        border-radius: 4px;
        font-size: var(--font-sm);
        font-weight: 500;
        color: var(--white);
    }

    .badge-active {
        background: var(--approved);
    }

    .badge-completed {
        background: var(--secondary);
    }

    .badge-defaulted {
        background: var(--rejected);
    }

    .update-btn {
        background: var(--secondary);
        color: var(--white);
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(77, 35, 121, 0.3);
        cursor: pointer;
        transition: all var(--transition-medium);
    }

    .update-btn:hover {
        background: var(--secondary2);
        box-shadow: 0 6px 16px rgba(77, 35, 121, 0.4);
        transform: translateY(-2px);
    }

    /* Payment Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1000;
        animation: fadeIn var(--transition-medium) forwards;
    }

    .modal-content {
        background: var(--white);
        margin: 5% auto;
        padding: var(--spacing-lg);
        border-radius: var(--radius);
        width: 90%;
        max-width: 500px;
        box-shadow: 0 var(--spacing-lg) 40px rgba(0, 0, 0, 0.15);
        animation: slideIn var(--transition-medium) both;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-lg);
        padding-bottom: var(--spacing-md);
        border-bottom: 1px solid var(--gray);
    }

    .modal-header h3 {
        color: var(--primary);
        font-weight: 600;
    }

    .close {
        font-size: 1.5rem;
        color: var(--black2);
        cursor: pointer;
        transition: color var(--transition-fast);
    }

    .close:hover {
        color: var(--primary);
    }

    .form-group {
        margin-bottom: var(--spacing-md);
    }

    .form-group label {
        display: block;
        margin-bottom: var(--spacing-sm);
        color: var(--black1);
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: var(--spacing-sm) var(--spacing-md);
        border: 1px solid var(--black2);
        border-radius: 6px;
        font-size: var(--font-md);
        transition: all var(--transition-fast);
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(77, 35, 121, 0.2);
    }

    .btn-group {
        display: flex;
        justify-content: flex-end;
        gap: var(--spacing-md);
        margin-top: var(--spacing-lg);
    }

    .btn {
        padding: var(--spacing-sm) var(--spacing-lg);
        border-radius: 6px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all var(--transition-medium);
    }

    .btn-cancel {
        background: var(--gray);
        color: var(--black1);
    }

    .btn-cancel:hover {
        background: var(--black2);
        color: var(--white);
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
        box-shadow: 0 4px 12px rgba(77, 35, 121, 0.3);
    }

    .btn-primary:hover {
        background: var(--primary2);
        box-shadow: 0 6px 16px rgba(77, 35, 121, 0.4);
        transform: translateY(-2px);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .dashboard-container {
            grid-template-columns: 1fr;
        }
        
        .stats-section {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-section {
            grid-template-columns: 1fr;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--spacing-md);
        }
        
        .modal-content {
            width: 95%;
            padding: var(--spacing-md);
        }
    }

    @media (max-width: 576px) {
        .dashboard-container {
            padding: var(--spacing-md);
        }
        
        .loan-table-section,
        .stat-card {
            padding: var(--spacing-md);
        }
        
        th, td {
            padding: var(--spacing-sm);
        }
    }
</style>

<div class="dashboard-container">
    <?php
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // TOTAL AMOUNT LENT (from loan_application)
        $stmt = $pdo->query("
            SELECT SUM(loan_amount) as total_lent 
            FROM loan_application 
            WHERE status = 'approved'
        ");
        $totalLent = $stmt->fetch(PDO::FETCH_ASSOC)['total_lent'] ?? 0;

        // ACTIVE LOANS (from loan_tracking)
        $stmt = $pdo->query("
            SELECT COUNT(*) as active_loans 
            FROM loan_tracking 
            WHERE status = 'active'
        ");
        $activeLoans = $stmt->fetch(PDO::FETCH_ASSOC)['active_loans'] ?? 0;

        // TOTAL PAID (from loan_tracking)
        $stmt = $pdo->query("
            SELECT SUM(total_paid) as total_paid 
            FROM loan_tracking
        ");
        $totalPaid = $stmt->fetch(PDO::FETCH_ASSOC)['total_paid'] ?? 0;

        // PENDING BALANCE (from loan_tracking)
        $stmt = $pdo->query("
            SELECT SUM(current_balance) as pending_balance
            FROM loan_tracking
            WHERE status = 'active'
        ");
        $pendingBalance = $stmt->fetch(PDO::FETCH_ASSOC)['pending_balance'] ?? 0;

    } catch(PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
    ?>

    <!-- LOAN TABLE SECTION -->
    <div class="loan-table-section">
        <div class="section-header">
            <h2 class="section-title">Approved Loans</h2>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Borrower</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Purpose</th>
                        <th>Term</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $stmt = $pdo->query("
                            SELECT 
                                la.id,
                                la.first_name,
                                la.last_name,
                                la.loan_amount,
                                la.loan_purpose,
                                la.loan_term,
                                la.status,
                                la.submitted_at,
                                IFNULL(lt.current_balance, la.loan_amount) as current_balance,
                                IFNULL(lt.status, 'active') as tracking_status,
                                IFNULL(lt.total_paid, 0) as total_paid
                            FROM loan_application la
                            LEFT JOIN loan_tracking lt ON la.id = lt.loan_id
                            WHERE la.status = 'approved'
                            ORDER BY la.submitted_at DESC
                            LIMIT 15
                        ");

                        $prevLoanId = null;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // Add divider if this is a new loan (grouping would be better, but this is simple)
                            if ($prevLoanId !== null && $prevLoanId != $row['id']) {
                                echo '<tr class="loan-divider"></tr>';
                            }
                            $prevLoanId = $row['id'];
                            
                            $status = $row['tracking_status'];
                            $statusClass = 'badge-' . $status;
                            $currentBalance = $row['current_balance'];
                            
                            echo '
                            <tr>
                                <td>#' . htmlspecialchars($row['id']) . '</td>
                                <td>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</td>
                                <td>₱' . number_format($row['loan_amount'], 2) . '</td>
                                <td>₱' . number_format($currentBalance, 2) . '</td>
                                <td>' . htmlspecialchars($row['loan_purpose']) . '</td>
                                <td>' . htmlspecialchars($row['loan_term']) . '</td>
                                <td><span class="badge ' . $statusClass . '">' . ucfirst($status) . '</span></td>
                                <td>
                                    <button class="update-btn" 
                                            onclick="showPaymentModal(' . $row['id'] . ', ' . $currentBalance . ')">
                                        <i class="fas fa-edit"></i> Manage
                                    </button>
                                </td>
                            </tr>';
                        }
                    } catch(PDOException $e) {
                        echo '<tr><td colspan="8">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- STATS SECTION -->
    <div class="stats-section">
        <div class="stat-card">
            <div class="card-header">
                <span class="card-title">Total Lent</span>
                <div class="card-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
            <div class="card-value">₱<?= number_format($totalLent, 2) ?></div>
            <div class="card-footer">
                <i class="fas fa-info-circle"></i> Original loan amounts
            </div>
        </div>

        <!-- Active Loans Card -->
        <div class="stat-card">
            <div class="card-header">
                <span class="card-title">Active Loans</span>
                <div class="card-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
            <div class="card-value"><?= $activeLoans ?></div>
            <div class="card-footer">
                <i class="fas fa-chart-line"></i> Currently active
            </div>
        </div>

        <!-- Total Paid Card -->
        <div class="stat-card">
            <div class="card-header">
                <span class="card-title">Total Paid</span>
                <div class="card-icon">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="card-value">₱<?= number_format($totalPaid, 2) ?></div>
            <div class="card-footer">
                <i class="fas fa-check-circle"></i> Repaid amount
            </div>
        </div>

        <!-- Pending Balance Card -->
        <div class="stat-card">
            <div class="card-header">
                <span class="card-title">Pending Balance</span>
                <div class="card-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="card-value">₱<?= number_format($pendingBalance, 2) ?></div>
            <div class="card-footer">
                <i class="fas fa-exclamation-circle"></i> Remaining balance
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Record Loan Payment</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <form id="paymentForm" onsubmit="submitPayment(event)">
            <input type="hidden" id="loanId">
            
            <div class="form-group">
                <label for="paymentAmount">Payment Amount (₱)</label>
                <input type="number" step="0.01" class="form-control" id="paymentAmount" required>
            </div>
            
            <div class="form-group">
                <label for="paymentDate">Payment Date</label>
                <input type="date" class="form-control" id="paymentDate" required>
            </div>
            
            <div class="form-group">
                <label for="paymentType">Payment Type</label>
                <select class="form-control" id="paymentType" required>
                    <option value="full">Full Payment</option>
                    <option value="partial">Partial Payment</option>
                    <option value="interest">Interest Only</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="paymentNotes">Notes</label>
                <textarea class="form-control" id="paymentNotes" rows="3"></textarea>
            </div>
            
            <div class="btn-group">
                <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Payment</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal functions
    function showPaymentModal(loanId, currentBalance) {
        document.getElementById('loanId').value = loanId;
        document.getElementById('paymentAmount').placeholder = "Current balance: ₱" + currentBalance.toFixed(2);
        document.getElementById('paymentAmount').max = currentBalance;
        document.getElementById('paymentAmount').value = '';
        document.getElementById('paymentDate').valueAsDate = new Date();
        document.getElementById('paymentModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('paymentModal').style.display = 'none';
    }

    // Submit payment form
    function submitPayment(event) {
        event.preventDefault();
        
        const loanId = document.getElementById('loanId').value;
        const amount = parseFloat(document.getElementById('paymentAmount').value);
        const date = document.getElementById('paymentDate').value;
        const type = document.getElementById('paymentType').value;
        const notes = document.getElementById('paymentNotes').value;
        
        fetch('process_payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                loan_id: loanId,
                amount: amount,
                date: date,
                type: type,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Payment of ₱${data.amount} recorded successfully.`);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing payment');
        });
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('paymentModal')) {
            closeModal();
        }
    }
</script>
<?php include 'footer.php'; ?>