<label for="">Статус</label>
<select class="form-control" name="published">
    @if(isset($post->id))
        <option value="0" @if($post->published == 0) selected="" @endif>
            Не опубликовано
        </option>
        <option value="1" @if($post->published == 1) selected="" @endif>
            Опубликовано
        </option>
    @else
        <option value="0">Не опубликовано</option>
        <option value="1">Опубликовано</option>
    @endif
</select>

<label for="title">Заголовок</label>
<input type="text" class="form-control" id="title" name="title" placeholder="Заголовок статьи" 
    value="{{$post->title ?? ''}}" required />

<label for="slug">Slug (Уникальное значение)</label>
<input type="text" class="form-control" id="slug" name="slug" placeholder="Автоматическая генерация" 
    value="{{$post->slug ?? ''}}" readonly />

<label for="parentCat">Родительская категория</label>
<select class="form-control" id="parentCat" name="categories[]" multiple="">
    @include('admin.posts.partitions.nested_categories', ['categories'=>$categories])
</select>

<label for="metaDescription">meta_description</label>
<input type="text" class="form-control" id="metaDescription" name="meta_description" placeholder="meta-description" 
    value="{{$post->meta_description ?? ''}}" required />

<label for="metaKeywords">meta-keywords</label>
<input type="text" class="form-control" id="metaKeywords" name="meta_keywords" placeholder="meta-keywords" 
    value="{{$post->meta_keywords ?? ''}}" required />
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
<label for="description">Краткое описание статьи</label>
<textarea cols="20" rows="2" id="description" name="description" style="width:100%">
    {{$post->description ?? ''}}
</textarea>

<label for="descriptionFull">Полное описание статьи</label>
<textarea cols="20" rows="4" id="descriptionFull" name="full_text" style="width:100%">
    {{$post->full_text ?? ''}}
</textarea>

<label>
    <input type="submit" class="btn btn-primary" value="Сохранить" />
</label>