

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Список задач</div>

                <div class="card-body">
                  <h4>Редактирование</h4>

                <form method="post" action="<?php echo e(route('todos.update')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="todo_id" value="<?php echo e($todo->id); ?>">
                  <div class="mb-3">
                     <label class="form-label">Название</label>
                     <input type="text" name="title" class="form-control" value="<?php echo e($todo->title); ?>">
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Описание</label>
                     <textarea name="description" class="form-control" cols="5" rows="5" ><?php echo e($todo->Описание); ?></textarea>
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Теги</label>
                        <input type="text" name="keywords" class="form-control p-4" value="<?php echo e($todo->keywords); ?>" data-role="tagsinput"/>
                  </div>
                  <div class="mb-3">
                    <strong>Изображение:</strong>
                    <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/jpg" placeholder="image" >
                    <img src="/images/origin/<?php echo e($todo->image); ?>" width="300px">
                  </div>
                  <div class="mb-3">
                    <label for="">Статус</label>
                    <select name="is_completed" class="form-control">
                        <option disabled selected>Выбрать</option>
                        <option value="1">Завершенный</option>
                        <option value="0">В работе</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Обновить</button>
               </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\todo\todo-laravel\resources\views/todos/edit.blade.php ENDPATH**/ ?>