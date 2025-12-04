<div class="panel">
    <div class="panel-heading"><b>Edit Subtopic</b></div>
    <div class="panel-body">
        <form method="post" action="">
            <div class="form-group">
                <label>Subtopic Title</label>
                <textarea name="subtopic_title" class="form-control" required><?= $subtopic['subtopic_title'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Order No.</label>
                <input type="number" name="subtopic_order" class="form-control" value="<?= $subtopic['subtopic_order'] ?>" required>
            </div>

            <div class="form-group">
                <label>Course Outcome (CO)</label>
                <input type="text" name="cos" class="form-control" value="<?= $subtopic['cos'] ?>" required>
            </div>

            <div class="form-group">
                <label>Hours</label>
                <input type="number" name="shours" class="form-control" value="<?= $subtopic['shours'] ?>" required>
            </div>

            <div class="form-group">
                <label>Minutes</label>
                <input type="number" name="sminutes" class="form-control" value="<?= $subtopic['sminutes'] ?>" required>
            </div>

            <button type="submit" class="btn btn-success">Update Subtopic</button>
            <a href="<?= base_url('SyllabusController') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
