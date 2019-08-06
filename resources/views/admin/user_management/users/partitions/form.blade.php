@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<label for="login">Логин</label>
<input type="text" class="form-control" id="login" name="login" placeholder="Логин" 
    value="@if(old('login')){{old('login')}}@else{{$user->login ?? ''}}@endif" required />
<label for="email">Почта</label>
<input type="email" class="form-control" id="email" name="email" placeholder="Почта" 
    value="@if(old('email')){{old('email')}}@else{{$user->email ?? ''}}@endif" required />
<label for="password">Пароль</label>
<input type="password" class="form-control" id="password" name="password" placeholder="Пароль" />
<label for="password">Подтверждение пароля</label>
<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Пароль" />

<label>
    <input type="submit" class="btn btn-primary" value="Сохранить" />
</label>