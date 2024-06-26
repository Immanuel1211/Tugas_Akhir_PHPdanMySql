<?php include("../layout/header.php");

$sql = "select * from users order by name";
$query = mysqli_query($db, $sql);

?>

<div class="container">
    <h2 style="text-align: center;">USER LIST</h2>
    <?php
    if (isset($_GET['error'])) {
    ?>
        <div class="alert alert-danger">
            <?= $_GET['error'] ?>
        </div>
    <?php
    }
    ?>
    <?php
    if (isset($_GET['success'])) {
    ?>
        <div class="alert alert-success">
            <?= $_GET['success'] ?>
        </div>
    <?php
    }
    ?>
    <a href="form.php" class="btn btn-primary my-2 ">Add</a></br>
    <table id="my-datatables" class="table table-striped table-bordered table-responsive">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            while ($user = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $user['name']; ?></td>
                    <td><?= $user['username']; ?></td>
                    <td>
                        <div class="d-flex">
                        <a href="form.php?id=<?= $user["id"]; ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                        <form action="delete-process.php" method="post">
                            <input type="hidden" name="id" value="<?= $user["id"]; ?>">
                            <button type="submit" name="submit" onclick="return confirm('Anda yakin menghapus data ini?');" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        </div>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
</div>

<?php include("../layout/footer.php"); ?>