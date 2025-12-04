<h3>My Assignments</h3>
<table class="table table-striped">
  <thead><tr><th>Title</th><th>Due</th><th>Status</th><th>Marks</th><th>Action</th></tr></thead>
  <tbody>
    <?php foreach($list as $r): ?>
      <tr>
        <td><?=$r->title?></td>
        <td><?=$r->due_date?></td>
        <td><?=$r->status?></td>
        <td><?=$r->marks_obtained?></td>
        <td>
          <form method="post" enctype="multipart/form-data" action="<?=base_url('assignment/submit')?>">
            <input type="hidden" name="assignment_id" value="<?=$r->id?>">
            <input type="file" name="answer_file" class="form-control" style="width:220px;display:inline-block">
            <button class="btn btn-sm btn-success">Submit</button>
          </form>
        </td>
      </tr>
    <?php endforeach;?>
  </tbody>
</table>
