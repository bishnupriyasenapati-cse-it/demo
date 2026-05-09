<?php
session_start();
include 'header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<div class="container-fluid mt-4">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-lg-2">
            <?php include 'sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="col-lg-10">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary">💳 Gym Payment Dashboard</h3>
                <span class="badge bg-success px-3 py-2">Admin Panel</span>
            </div>

            <!-- Payment Form -->
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-gradient bg-primary text-white">
                    <h5 class="mb-0">➕ Record New Payment</h5>
                </div>
                <div class="card-body">
                    <form id="paymentForm" class="row g-3">

                        <div class="col-md-3">
                            <label class="form-label">Member ID</label>
                            <input type="text" id="member_id" name="member_id" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Member Name</label>
                            <input type="text" id="name" class="form-control bg-light" readonly>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control bg-light" readonly>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Method</label>
                            <select name="method" class="form-select">
                                <option value="UPI">UPI</option>
                                <option value="Card">Card</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>

                        <div class="col-md-2 d-grid">
                            <label class="form-label invisible">Submit</label>
                            <button class="btn btn-success">💰 Pay</button>
                        </div>

                    </form>

                    <div id="response" class="mt-3"></div>
                </div>
            </div>

            <!-- Payment Table -->
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between">
                    <h5 class="mb-0">📊 Payment Records</h5>
                    <button class="btn btn-sm btn-light" id="refreshBtn">🔄 Refresh</button>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover text-center" id="paymentTable">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Member</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="6">⏳ Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function loadPayments() {
    $("#paymentTable tbody").html("<tr><td colspan='6'>⏳ Loading...</td></tr>");

    $.ajax({
        url: "fetch_payments.php",
        method: "GET",
        dataType: "json",
        success: function(res) {
            let html = "";

            if(res.status === "success" && res.data.length > 0){
                res.data.forEach((p, index) => {

                    let badge = `<span class='badge bg-secondary'>Unknown</span>`;
                    if(p.status === "success") badge = `<span class='badge bg-success'>Paid</span>`;
                    if(p.status === "pending") badge = `<span class='badge bg-warning text-dark'>Pending</span>`;
                    if(p.status === "failed") badge = `<span class='badge bg-danger'>Failed</span>`;

                    let date = new Date(p.created_at).toLocaleString();

                    html += `
                    <tr>
                        <td>${index+1}</td>
                        <td><strong>${p.name}</strong><br><small>ID: ${p.member_id}</small></td>
                        <td>₹${p.amount}</td>
                        <td>${p.payment_method}</td>
                        <td>${badge}</td>
                        <td>${date}</td>
                    </tr>`;
                });
            } else {
                html = "<tr><td colspan='6'>No records found</td></tr>";
            }

            $("#paymentTable tbody").html(html);
        },
        error: () => {
            $("#paymentTable tbody").html("<tr><td colspan='6'>Error loading data</td></tr>");
        }
    });
}

$(document).ready(function(){

    // 🔍 AUTO FETCH MEMBER
    let timer;
    $("#member_id").keyup(function(){
        clearTimeout(timer);
        let id = $(this).val().trim();

        timer = setTimeout(function(){
            if(id === ""){
                $("#name, #amount").val("");
                return;
            }

            $.getJSON("fetch_members.php", {member_id:id}, function(res){

                if(!res.error){
                    $("#name").val(res.name);
                    $("#amount").val(res.price);
                } else {
                    $("#name").val(res.error);
                    $("#amount").val("");
                }

            }).fail(function(){
                $("#name").val("Error");
            });

        }, 400);
    });

    loadPayments();
    $("#refreshBtn").click(loadPayments);

    // 💰 SUBMIT PAYMENT
    $("#paymentForm").submit(function(e){
        e.preventDefault();

        let name = $("#name").val();
        let amount = $("#amount").val();

        if(name.includes("error") || name.includes("Not") || amount == ""){
            $("#response").html("<div class='alert alert-danger'>Invalid Member ❌</div>");
            return;
        }

        let btn = $("#paymentForm button");
        btn.text("Processing...").prop("disabled", true);

        $.ajax({
            url: "process_payment.php",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",

            success: function(res){

                if(res.status === "success"){

                    $("#response").html(`<div class='alert alert-success'>
                        Payment Created ✅ TXN: <b>${res.transaction_id}</b>
                    </div>`);

                    // ✅ REAL webhook using SAME transaction ID
                    setTimeout(function(){
                        $.ajax({
                            url: "webhook.php",
                            method: "POST",
                            contentType: "application/json",
                            data: JSON.stringify({
                                transaction_id: res.transaction_id,
                                status: "success"
                            }),
                            success: loadPayments
                        });
                    }, 2000);

                } else {
                    $("#response").html(`<div class='alert alert-danger'>${res.message}</div>`);
                }

                $("#paymentForm")[0].reset();
                $("#name, #amount").val("");
                btn.text("💰 Pay").prop("disabled", false);
                loadPayments();
            },

            error: function(){
                $("#response").html("<div class='alert alert-danger'>Server Error ❌</div>");
                btn.text("💰 Pay").prop("disabled", false);
            }
        });

    });

});
</script>

