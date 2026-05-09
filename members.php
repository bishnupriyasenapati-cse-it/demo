<?php
session_start();
include 'db.php';

// ================= API HANDLER =================
if (isset($_GET['action'])) {

    header('Content-Type: application/json');

    if ($_GET['action'] == 'fetch') {
        $stmt = $pdo->query("SELECT * FROM members ORDER BY id DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    if ($_GET['action'] == 'insert') {
        $stmt = $pdo->prepare("
            INSERT INTO members (name, phone, email, gender, join_date, membership, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $_POST['name'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['gender'],
            $_POST['join_date'],
            $_POST['membership'],
            $_POST['status']
        ]);

        echo json_encode(["status" => "success"]);
        exit;
    }

    if ($_GET['action'] == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM members WHERE id=?");
        $stmt->execute([$_POST['id']]);

        echo json_encode(["status" => "deleted"]);
        exit;
    }

    if ($_GET['action'] == 'update') {
        $stmt = $pdo->prepare("
            UPDATE members SET name=?, phone=?, email=?, gender=?, join_date=?, membership=?, status=? 
            WHERE id=?
        ");
        $stmt->execute([
            $_POST['name'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['gender'],
            $_POST['join_date'],
            $_POST['membership'],
            $_POST['status'],
            $_POST['id']
        ]);

        echo json_encode(["status" => "updated"]);
        exit;
    }

    if ($_GET['action'] == 'search') {
        $search = "%" . $_POST['search'] . "%";
        $stmt = $pdo->prepare("SELECT * FROM members WHERE name LIKE ?");
        $stmt->execute([$search]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }
}
?>

<!-- NOW LOAD UI -->
<?php include 'header.php'; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <?php include 'sidebar.php'; ?>
        </div>

        <div class="col-lg-10">
            <h2>Members Dashboard</h2>

            <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addMember">
                Add Member
            </button>

            <input type="text" id="search" class="form-control w-25 mb-3" placeholder="Search...">
            <div id="msg"></div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Join Date</th>
                        <th>Membership</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="memberTable"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addMember">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="memberForm">
                    <input name="name" class="form-control mb-2" placeholder="Name">
                    <input name="phone" class="form-control mb-2" placeholder="Phone">
                    <input name="email" class="form-control mb-2" placeholder="Email">
                    <input name="gender" class="form-control mb-2" placeholder="Gender">
                    <input type="date" name="join_date" class="form-control mb-2">
                    <input name="membership" class="form-control mb-2" placeholder="Membership">
                    <input name="status" class="form-control mb-2" placeholder="Status">

                    <button class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        loadMembers();
    });

    // 🔔 Notification
    function showMsg(text, type = "success") {

        let alertBox = $(`
        <div class="alert alert-${type} alert-dismissible fade show" role="alert"
             style="position:fixed; top:20px; right:20px; z-index:9999; min-width:250px;">
            ${text}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);

        $("body").append(alertBox);

        setTimeout(() => {
            alertBox.alert('close');
        }, 3000);
    }

    // LOAD MEMBERS
    function loadMembers() {
        $.ajax({
            url: "members.php?action=fetch",
            type: "GET",
            dataType: "json",
            success: function (data) {

                let html = "";

                data.forEach(m => {
                    html += `
                <tr>
                    <td class="id">${m.id}</td>
                    <td class="name">${m.name}</td>
                    <td class="phone">${m.phone}</td>
                    <td class="email">${m.email}</td>
                    <td class="gender">${m.gender}</td>
                    <td class="join_date">${m.join_date}</td>
                    <td class="membership">${m.membership}</td>
                    <td class="status">${m.status}</td>
                    <td>
                        <button class="btn btn-primary editBtn">Edit</button>
                        <button class="btn btn-danger deleteBtn" data-id="${m.id}">Delete</button>
                    </td>
                </tr>`;
                });

                $("#memberTable").html(html);
            },
            error: function () {
                showMsg("Failed to load members", "danger");
            }
        });
    }

    // INSERT
    $("#memberForm").submit(function (e) {
        e.preventDefault();

        $.post("members.php?action=insert", $(this).serialize(), function (res) {

            if (res.status === "success") {
                showMsg("Member Added");
                $("#memberForm")[0].reset();
                $("#addMember").modal('hide');
                loadMembers();
            } else {
                showMsg("Insert failed", "danger");
            }

        }, "json");
    });

    // DELETE
    $(document).on("click", ".deleteBtn", function () {

        if (!confirm("Are you sure?")) return;

        $.post("members.php?action=delete", { id: $(this).data("id") }, function (res) {

            if (res.status === "deleted") {
                showMsg("Member Deleted", "danger");
                loadMembers();
            } else {
                showMsg("Delete failed", "danger");
            }

        }, "json");
    });

    // EDIT
    $(document).on("click", ".editBtn", function () {
        let row = $(this).closest("tr");

        row.find(".id").html(`<input class="edit_id form-control" value="${row.find(".id").text()}" readonly>`);
        row.find(".name").html(`<input class="edit_name form-control" value="${row.find(".name").text()}">`);
        row.find(".phone").html(`<input class="edit_phone form-control" value="${row.find(".phone").text()}">`);
        row.find(".email").html(`<input class="edit_email form-control" value="${row.find(".email").text()}">`);
        row.find(".gender").html(`<input class="edit_gender form-control" value="${row.find(".gender").text()}">`);
        row.find(".join_date").html(`<input type="date" class="edit_join_date form-control" value="${row.find(".join_date").text()}">`);
        row.find(".membership").html(`<input class="edit_membership form-control" value="${row.find(".membership").text()}">`);
        row.find(".status").html(`<input class="edit_status form-control" value="${row.find(".status").text()}">`);

        $(this).replaceWith(`<button class="btn btn-success saveBtn">Save</button>`);
    });

    // UPDATE
    $(document).on("click", ".saveBtn", function () {
        let row = $(this).closest("tr");

        $.post("members.php?action=update", {
            id: row.find(".edit_id").val(),
            name: row.find(".edit_name").val(),
            phone: row.find(".edit_phone").val(),
            email: row.find(".edit_email").val(),
            gender: row.find(".edit_gender").val(),
            join_date: row.find(".edit_join_date").val(),
            membership: row.find(".edit_membership").val(),
            status: row.find(".edit_status").val()
        }, function (res) {

            if (res.status === "updated") {
                showMsg("Member Updated", "info");
                loadMembers();
            } else {
                showMsg("Update failed", "danger");
            }

        }, "json");
    });

    // SEARCH
    $("#search").keyup(function () {

        $.post("members.php?action=search", { search: $(this).val() }, function (data) {

            let html = "";

            data.forEach(m => {
                html += `<tr>
                <td>${m.id}</td>
                <td>${m.name}</td>
                <td>${m.phone}</td>
                <td>${m.email}</td>
                <td>${m.gender}</td>
                <td>${m.join_date}</td>
                <td>${m.membership}</td>
                <td>${m.status}</td>
            </tr>`;
            });

            $("#memberTable").html(html);

        }, "json");
    });


</script>

<?php include 'footer.php'; ?>