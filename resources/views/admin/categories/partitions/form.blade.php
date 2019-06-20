<label for="">Статус</label>
<select class="form-control" name="published">
    @if(isset($category->id))
        <option value="0" @if($category->published == 0) selected="" @endif>
            Не опубликовано
        </option>
        <option value="1" @if($category->published == 1) selected="" @endif>
            Опубликовано
        </option>
    @else
        <option value="0">Не опубликовано</option>
        <option value="1">Опубликовано</option>
    @endif
</select>

<label for="title">Наименование</label>
<input type="text" class="form-control" id="title" name="title" placeholder="Заголовок категории" 
    value="{{$category->title ?? ''}}" required />
<label for="descriptionCat">Описание категории</label>
<textarea cols="20" rows="2" id="descriptionCat" name="description" style="width:100%">
    {{$category->description ?? ''}}
</textarea>

<label for="slug">Slug</label>
<input type="text" class="form-control" id="slug" name="slug" placeholder="Автоматическая генерация" 
    value="{{$category->slug ?? ''}}" readonly />

<label for="parentCat">Родительская категория</label>
<select class="form-control" id="parentCat" name="parent_id">
    <option value="0">-- Без родительской категории--</option>
    @include('admin.categories.partitions.nested_categories', ['categories'=>$categories])
</select>

<label>
    <input type="submit" class="btn btn-primary" value="Сохранить" />
</label>