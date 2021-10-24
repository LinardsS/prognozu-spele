<?php if (count($errors) > 0): ?>
  <?php foreach ($errors->all() as $error): ?>
    <div class="alert alert-danger">
      {{$error}}
    </div>
  <?php endforeach; ?>
<?php endif; ?>

@if(session('success'))
<div class="alert alert-success">
  {{session('success')}}
</div>
@endif
