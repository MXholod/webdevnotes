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

<label for="m-desc">meta_description</label>
<input type="text" class="form-control" id="m-desc" name="meta_d" placeholder="Meta описание" 
    value="{{$category->meta_description ?? ''}}" />

<label for="m-key">meta-keywords</label>
<input type="text" class="form-control" id="m-key" name="meta_k" placeholder="Meta слова" 
    value="{{$category->meta_keywords ?? ''}}" />

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

@if(isset($firstFiles) && isset($firstScripts))
<create-aditional-js-component 
    :file-paths="{{json_encode($firstFiles)}}" 
    :db-paths="{{json_encode($firstScripts)}}"
    >
</create-aditional-js-component>
@endif
@if(isset($files) && isset($activeScripts))
<aditional-js-component 
    :file-paths="{{json_encode($files)}}" 
    :db-paths="{{json_encode($activeScripts)}}"
    >
</aditional-js-component>
@endif

<label>
    <input type="submit" class="btn btn-primary" value="Сохранить" />
</label>