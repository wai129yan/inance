<!-- <div class="alert alert-danger alert-dismissible fade show w-50 m-auto" role="alert">
    <strong><= $err ?></strong>
    <button type="button" class="class" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div> -->



<?php

if (count($errors) == 0) return;
foreach ($errors as $key => $err) { ?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong><?= $err ?></strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>