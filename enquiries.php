<?php include 'header.php'; 

// Start session to track admin login
session_start();

// Redirect to login if admin not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

?>

<?php require 'db.php'; ?>

<div class="d-flex">

    <!-- SIDEBAR -->
    <?php include 'sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="container-fluid p-4" style="background:#f4f6f9; min-height:100vh;">

        <?php
        // Fetch all enquiries from database (latest first)
        $stmt = $pdo->prepare("SELECT * FROM enquiries ORDER BY id DESC");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!-- HEADER CARD -->
        <div class="card shadow mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                
                <!-- Title Section -->
                <div>
                    <h4 class="mb-0">📩 Enquiry Management</h4>
                    <small class="text-muted">Manage customer enquiries easily</small>
                </div>

                <!-- Search Input -->
                <input type="text" id="search" class="form-control w-25" placeholder="Search enquiry...">
            </div>
        </div>

        <!-- ENQUIRY CARDS -->
        <div class="row">

            <?php foreach ($rows as $row) { ?>

            <!-- Single Enquiry Card -->
            <div class="col-md-4 mb-4 enquiry-item">

                <div class="card shadow-sm h-100">

                    <div class="card-body">

                        <!-- TOP INFO: ID + DATE -->
                        <div class="d-flex justify-content-between">
                            <span class="badge bg-primary">#<?= $row['id']; ?></span>

                            <!-- NOTE: This shows current date, not DB date -->
                            <small class="text-muted"><?= date('d M Y'); ?></small>
                        </div>

                        <hr>

                        <!-- CUSTOMER DETAILS -->
                        <h5><?= htmlspecialchars($row['name']); ?></h5>
                        <p class="text-muted mb-1"><?= htmlspecialchars($row['email']); ?></p>

                        <!-- SHORT MESSAGE PREVIEW -->
                        <p class="small">
                            <?= substr(htmlspecialchars($row['message']),0,80); ?>...
                        </p>

                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="card-footer bg-white text-end">

                        <!-- Reply Button -->
                        <button class="btn btn-sm btn-success replyBtn"
                            data-id="<?= $row['id']; ?>"
                            data-email="<?= htmlspecialchars($row['email']); ?>"
                            data-name="<?= htmlspecialchars($row['name']); ?>">
                            Reply
                        </button>

                        <!-- Delete Button -->
                        <button class="btn btn-sm btn-danger deleteBtn"
                            data-id="<?= $row['id']; ?>">
                            Delete
                        </button>

                    </div>

                </div>

            </div>

            <?php } ?>

        </div>

    </div>

</div>

<!-- REPLY MODAL (POPUP) -->
<div class="modal fade" id="replyModal" tabindex="-1">
  <div class="modal-dialog">

    <!-- Reply Form -->
    <form id="replyForm">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Send Reply</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <!-- Hidden Fields -->
          <input type="hidden" id="rId" name="id">
          <input type="hidden" id="rEmail" name="email">

          <!-- Name (readonly) -->
          <div class="mb-2">
            <label>Name</label>
            <input type="text" id="rName" class="form-control" readonly>
          </div>

          <!-- Reply Message -->
          <div class="mb-2">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">Send Reply</button>
        </div>

      </div>
    </form>
  </div>
</div>

<script>

// ================= SEARCH FUNCTION =================
// Filters enquiry cards based on search input
$("#search").on("keyup", function () {
    let value = $(this).val().toLowerCase();

    $(".enquiry-item").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

// ================= DELETE FUNCTION =================
// Deletes enquiry using AJAX
$(document).on("click", ".deleteBtn", function () {
    let id = $(this).data("id");

    if (confirm("Delete this enquiry?")) {
        $.post("delete_enquiry.php", { id: id }, function () {
            location.reload(); // Refresh page after delete
        });
    }
});

// ================= OPEN REPLY MODAL =================
// Fills modal with enquiry data and opens it
$(document).on("click", ".replyBtn", function () {

    let id = $(this).data("id");
    let email = $(this).data("email");
    let name = $(this).data("name");

    // Set values in modal fields
    $("#rId").val(id);
    $("#rEmail").val(email);
    $("#rName").val(name);

    // Open Bootstrap modal
    let modal = new bootstrap.Modal(document.getElementById('replyModal'));
    modal.show();
});


// ================= SEND REPLY =================
// Sends reply using AJAX without reloading page
$("#replyForm").submit(function (e) {
    e.preventDefault();

    let form = $(this);

    $.post("send_reply.php", form.serialize(), function (res) {

        if (res.trim() === "success") {

            alert("✅ Reply sent successfully!");

            // Close modal
            let modalEl = document.getElementById('replyModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            // Reset form
            form[0].reset();

        } else {
            alert("❌ Error: " + res);
        }

    }).fail(function () {
        alert("❌ Server error!");
    });
});

</script>

<?php include 'footer.php'; ?>