<html>
<head><title>Student - Live Sessions</title></head>
<body>
<h2>Available Live Sessions</h2>
<table border="1" cellpadding="6">
    <tr><th>ID</th><th>Title</th><th>Start</th><th>Action</th></tr>
    <?php foreach($sessions as $s): ?>
    <tr>
        <td><?php echo $s->id; ?></td>
        <td><?php echo $s->title; ?></td>
        <td><?php echo $s->start_time; ?></td>
        <td>
            <a href="<?php echo site_url('live_session/join/'.$s->id); ?>">Join (Mark Attendance & Open Meet)</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
