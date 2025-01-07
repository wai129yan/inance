<?php

if (count($success) == 0) return;
foreach ($success as $key => $data) { ?>
    <div class="alert alert-success alert-dismissible fade show w-75 d-flex justify-content-between pr-3 align-items-center" role="alert">
        <strong><?= $data ?></strong>
        <button type="button" class="" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php } ?>