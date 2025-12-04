<?php
$PAGE_W = 210; $PAGE_H = 148; // A5-L
$OFFSET_Y = 6;                // mm: + pushes down, - pulls up
$COL_LABEL = 50; $COL_COLON = 20;
$rows = [
  ['Name', $student['stud_name'] ?? ''],
  ['Permanent Registration Number', $student['enrollment_no'] ?? ''],
  ['Son/Daughter of', $student['father_name'] ?? ''],
  ['Degree (with Specialization)', $student['degree_with_specialization'] ?? ''],
  ['Month and Year of Passing', $student['month_year_of_passing'] ?? ''],
['Classification', $student['classification'] ?? ''],
];
?>
<style>
  body { 
    font-family: "Bookman Old Style", "Times New Roman", serif; 
    margin: 0; 
    background: #fff; 
    color: #000;
  }
  .page { width:<?= $PAGE_W ?>mm; height:<?= $PAGE_H ?>mm; }
  .full { width:100%; height:100%; border-collapse:collapse; }
  .inner { width: 150mm; } /* width of your content block */
  .title { font-size:14px; margin:0 0 5mm 0; line-height:1.28; }
   table.tbl { 
	  width: 100%; 
	  table-layout: fixed; 
	  border-collapse: collapse; 
	  font-size: 13px; 
	}

	.tbl td { 
	  padding: 3px 0;           /* adds vertical padding for breathing space */
	  vertical-align: top; 
	  line-height: 1.6;         /* increases line height for better readability */
	}
  .lbl { width:<?= $COL_LABEL ?>mm; font-weight:bold; white-space:nowrap; }
  .colon { width:<?= $COL_COLON ?>mm; text-align:center; font-weight:bold;}
  .val { font-size:14px; font-weight:700; word-break:break-word; overflow-wrap:anywhere; font-weight:bold; }
  .note { margin-top:6mm; font-size:14px; line-height:1.35; }
</style>

<div class="page">
  <table class="full">
    <tr>
      <td style="vertical-align:middle; padding-top: <?= max(0,$OFFSET_Y) ?>mm; padding-bottom: <?= max(0,-$OFFSET_Y) ?>mm;">
        <div class="inner" style="margin-left:42mm;"><!-- move right by changing this -->
          <div class="title">
            This is to certify that the under mentioned candidate has qualified for the
            award of <em>degree</em> as detailed below:
          </div></br>

          <table class="tbl">
            <?php foreach ($rows as $r): ?>
              <tr><td class="lbl"><?= htmlspecialchars($r[0]) ?></td><td class="colon">:</td><td class="val"><?= htmlspecialchars($r[1]) ?></td></tr>
            <?php endforeach; ?>
          </table></br>

          <div class="note">
            The Degree Certificate will be awarded to him/her at the next Convocation of the University or thereafter.
          </div>
        </div>
      </td>
    </tr>
  </table>
</div>




