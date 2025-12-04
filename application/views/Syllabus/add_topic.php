<h3>Add Topic</h3>
<form method="post">
    <label>Subject ID: <input type="number" name="subject_id" required></label><br>
    <label>Topic Title: <input type="text" name="topic_title" required></label><br>
    <label>Order: <input type="number" name="topic_order" required></label><br>
    <button type="submit">Save</button>
</form>
<a href="<?= base_url('SyllabusController') ?>">Back</a>
