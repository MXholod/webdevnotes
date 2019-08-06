<label for="login">Логин</label>
<input type="text" class="form-control" id="login" name="login" placeholder="Логин" 
    value="{{$user->login ?? ''}}" required />
<label for="email">Почта</label>
<input type="email" class="form-control" id="email" name="email" placeholder="Почта" 
    value="{{$user->email ?? ''}}" required />
<label for="password">Пароль</label>
<input type="password" class="form-control" id="password" name="password" placeholder="Пароль" 
    required />
<label for="password">Подтверждение пароля</label>
<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Пароль" 
    required />

<label>
    <input type="submit" class="btn btn-primary" value="Сохранить" />
</label>