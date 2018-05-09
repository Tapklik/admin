<?php $__env->startSection('breadcrumbs'); ?>
    Accounting
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<auth></auth>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer-js-header'); ?>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/amcharts.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/serial.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/themes/light.js?ver=20170519-02'></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>