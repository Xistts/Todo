

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><?php echo e(__('Список')); ?></div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
                     <a href="<?php echo e(url()->previous()); ?>" class="btn btn-sm btn-info">Назад</a><br>
                    <b>Название: </b> <?php echo e($todo->title); ?><br>
                    <b>Описание: </b> <?php echo e($todo->description); ?><br>
                    <b>Теги: </b> 
                                <?php $__currentLoopData = explode(",",$todo->keywords); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="inner btn-sm btn-info"><?php echo e($tag); ?></label>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><br>
                    <img src="/images/origin/<?php echo e($todo->image); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\todo\todo-laravel\resources\views/todos/show.blade.php ENDPATH**/ ?>