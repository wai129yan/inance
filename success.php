<?php

if (count($success) == 0) return;
foreach ($success as $key => $data) { ?>
    <div class="alert alert-success alert-dismissible fade show w-50 m-auto" role="alert">
        <strong><?= $data ?></strong>
        <button type="button" class="class" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php } ?>