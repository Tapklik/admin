<?php $__env->startSection('head_scripts'); ?>
    var obj = {id: '<?php echo $creatives['id']; ?>'}
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    Manage Campaign Creatives
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <creatives></creatives>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>