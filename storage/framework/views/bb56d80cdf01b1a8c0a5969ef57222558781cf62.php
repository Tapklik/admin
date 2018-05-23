<?php $__env->startSection('head_scripts'); ?>
    var obj = {id: <?php echo $account['id']; ?>}
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    Graphs
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<support-graphs></support-graphs>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>