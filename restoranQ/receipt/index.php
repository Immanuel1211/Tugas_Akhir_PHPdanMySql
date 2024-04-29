<?php
include("../layout/header.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT r.*, u.name as user_name, IFNULL(SUM(rd.price * rd.amount), 0) as total  
        FROM receipts r
        INNER JOIN users u ON u.id = r.user_id
        LEFT JOIN receipt_details rd ON r.id = rd.receipt_id
        WHERE r.status = 'entry'
        GROUP BY r.id";
$query = mysqli_query($db, $sql);

if (!$query) {
    die("Query failed: " . mysqli_error($db));
}

?>

<?php
if(isset($_GET['error'])) {
?>
<div class="alert alert-danger">
    <?= $_GET['error']; ?>
</div>
<?php
}
if(isset($_GET['success'])) {
?>
<div class="alert alert-success">
    <?= $_GET['success']; ?>
</div>
<?php
}
?>

<div class="container mt-4">
    <h1 class="text-center">Receipt List</h1>

    <a href="form.php" class="btn btn-primary my-3" style="width:100px">Add</a>

    <div class="table-responsive">
        <table id="my-datatables" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($receipt = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= date("d-m-Y H:i:s", strtotime($receipt["receipt_date"])); ?></td>
                    <td><?= $receipt['customer_name']; ?></td>
                    <td><?= number_format($receipt["total"],0, '.', '.') ?></td>
                    <td class="text-end"><?= $receipt["status"]; ?></td>
                    <td><?= $receipt['user_name']; ?></td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="form.php?id=<?= $receipt['id']; ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="delete-process.php" method="post" onsubmit="return confirm('Anda yakin menghapus data ini?');">
                                <input type="hidden" name="id" value="<?= $receipt['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include("../layout/footer.php");
?>