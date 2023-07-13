

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создание задачи</div>

                <div class="card-body">

                <?php if($errors->any()): ?>
                  <div class="alert alert-danger">
                     <ul>
                           <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li><?php echo e($error); ?></li>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </ul>
                  </div>
               <?php endif; ?>

                <form method="post" action="<?php echo e(route('todos.store')); ?>" enctype="multipart/form-data">
                  <?php echo csrf_field(); ?>
                  <div class="mb-3">
                     <label class="form-label">Название</label>
                     <input type="text" name="title" class="form-control" >
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Описания</label>
                     <textarea name="description" class="form-control" cols="5" rows="5"></textarea>
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Теги</label>
                        <input type="text" name="keywords" class="form-control" data-role="tagsinput">
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Пользователи</label>
                        <select name="id_user_content" class="form-control" multiple>
                           <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($user->id != auth()->user()->id): ?>
                              <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                           <?php endif; ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Роли пользователей</label>
                        <select name="role" class="form-control">
                              <option value="">Выбрать роль</option>
                              <option value="0">Чтение</option>
                              <option value="1">Редактирование</option>
                        </select>
                  </div>
                  <div class="mb-3">
                     <strong>Image:</strong>
                     <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/jpg" placeholder="image">
                  </div>
                  <button type="submit" class="btn btn-primary">Подтвердить</button>
               </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\todo\todo-laravel\resources\views/todos/create.blade.php ENDPATH**/ ?>