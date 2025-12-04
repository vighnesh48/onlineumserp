<h3>Create Assignment</h3>
<form method="post" action="<?= base_url('assignment/store') ?>">
    <input type="hidden" name="subject_id" value="<?= $subject_id ?>">
    <input type="hidden" name="campus_id"  value="<?= $campus_id ?>">

    <label>Lecture Plan (optional, picks topic/subtopic)</label>
    <select id="lp" class="form-control">
        <option value="">-- Select --</option>
        <?php foreach($plans as $p): 
            $topic = ($p->topic_order ? $p->topic_order.'. ' : '').$p->topic_title;
            $sub   = $p->subtopic_title ? ($p->srno.'. '.$p->subtopic_title) : '';
        ?>
        <option data-topic="<?=$p->topic_id?>" data-sub="<?=$p->subtopic_id?>" value="<?=$p->plan_id?>">
            <?=$topic?> <?=$sub ? ' → '.$sub : ''?>
        </option>
        <?php endforeach;?>
    </select>
    <input type="hidden" name="lecture_plan_id" id="lecture_plan_id">
    <input type="hidden" name="topic_id" id="topic_id">
    <input type="hidden" name="subtopic_id" id="subtopic_id">

    <label class="mt-2">Title</label>
    <input class="form-control" name="title" required>

    <label>Description</label>
    <textarea class="form-control" name="description"></textarea>

    <div class="row">
        <div class="col-sm-4">
            <label>Due Date</label>
            <input type="date" class="form-control" name="due_date" required>
        </div>
        <div class="col-sm-4">
            <label>Max Marks</label>
            <input type="number" class="form-control" name="max_marks" max="999">
        </div>
    </div>

    <hr>
    <h4>Pick Questions (auto loads by Topic/Subtopic)</h4>
    <div id="qbox">Select a Lecture Plan to load questions…</div>

    <hr>
    <h4>Assign to Students</h4>
    <!-- Replace with your real student list/filters; for speed, just paste a textarea of student IDs -->
    <textarea class="form-control" name="student_ids[]" placeholder="Put student IDs or wire a checkbox list" rows="1"></textarea>
    <!-- For real use, render checkboxes here from a $students list -->

    <button class="btn btn-primary mt-3">Create Assignment</button>
</form>

<script>
document.getElementById('lp').addEventListener('change', function(){
    const opt = this.options[this.selectedIndex];
    document.getElementById('lecture_plan_id').value = this.value || '';
    document.getElementById('topic_id').value        = opt.dataset.topic || '';
    document.getElementById('subtopic_id').value     = opt.dataset.sub || '';

    if(opt.dataset.topic){
        fetch('<?=base_url('assignment/ajax_questions')?>', {
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                subject_id:'<?=$subject_id?>',
                campus_id:'<?=$campus_id?>',
                topic_id: opt.dataset.topic,
                subtopic_id: opt.dataset.sub
            })
        }).then(r=>r.json()).then(rows=>{
            let html='';
            if(!rows.length){ html='<div class="text-muted">No questions found for this topic/subtopic.</div>'; }
            else{
                rows.forEach(q=>{
                    html+=`<div class="border p-2 mb-1">
                              <label>
                                <input type="checkbox" name="question_ids[]" value="${q.id}"> 
                                <strong>[${q.blooms_level||''} ${q.course_outcome||''}]</strong> 
                                ${q.question_text.replace(/<[^>]+>/g,'')}
                                <em class="text-muted"> (Marks: ${q.marks||''})</em>
                              </label>
                           </div>`;
                });
            }
            document.getElementById('qbox').innerHTML = html;
        });
    } else {
        document.getElementById('qbox').innerHTML = 'Select a Lecture Plan to load questions…';
    }
});
</script>
