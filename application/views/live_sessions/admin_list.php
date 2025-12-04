<html>
<head><title>Admin - Live Sessions</title></head>
<body>
<?php if ($this->session->flashdata('message')): ?>
    <p style="color:green;"><?php echo $this->session->flashdata('message'); ?></p>
<?php endif; ?>

<h2>Create session (demo)</h2>
<form method="post" action="<?php echo site_url('live_session/create_demo'); ?>">
    Title: <input name="title" value="Live Class"><br>
    Start (Y-m-d H:i:s): <input name="start" value="<?php echo date('Y-m-d H:i:s'); ?>"><br>
    End (Y-m-d H:i:s): <input name="end" value="<?php echo date('Y-m-d H:i:s', strtotime('+1 hour')); ?>"><br>
    <button type="submit">Create Session (create Calendar event & Meet)</button>
</form>

<h2>Existing Sessions</h2>
<table border="1" cellpadding="6">
    <tr><th>ID</th><th>Title</th><th>Start</th><th>Meet</th></tr>
    <?php foreach($sessions as $s): ?>
    <tr>
        <td><?php echo $s->id; ?></td>
        <td><?php echo $s->title; ?></td>
        <td><?php echo $s->start_time; ?></td>
        <td><?php echo $s->meet_link ? '<a href="'.$s->meet_link.'" target="_blank">Open Meet</a>' : '—'; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
