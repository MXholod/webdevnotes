@extends('admin.layouts.admin_app')
@section('content')
    @push('webdev_scripts')
        <script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script>
            window.onload=function(){
                //CKEDITOR.replace( 'description' );
                CKEDITOR.replace( 'description',
            {
                customConfig : 'config.js',
                toolbar : 'simple'
            });
                CKEDITOR.replace( 'descriptionFull' );
            };
        </script>
    @endpush
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Редактировать страницу вывода ошибок @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Страница вывода ошибок @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="{{route('admin.error-page.update', $errorPage->id)}}" method="post">
                    <input type="hidden" name="_method" value="put" />
                    {{ csrf_field() }}
                    <label for="">Статус</label>
                    <select class="form-control" name="published">
                        @if(isset($errorPage->id))
                            <option value="0" @if($errorPage->published == 0) selected="" @endif>
                                Не опубликовано
                            </option>
                            <option value="1" @if($errorPage->published == 1) selected="" @endif>
                                Опубликовано
                            </option>
                        @else
                            <option value="0">Не опубликовано</option>
                            <option value="1">Опубликовано</option>
                        @endif
                    </select>
                    <label for="title">Заголовок</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок статьи" 
                        value="{{$errorPage->title ?? ''}}" required />

                    <label for="metaDescription">meta_description</label>
                    <input type="text" class="form-control" id="metaDescription" name="meta_description" placeholder="meta-description" 
                        value="{{$errorPage->meta_description ?? ''}}" required />

                    <label for="metaKeywords">meta-keywords</label>
                    <input type="text" class="form-control" id="metaKeywords" name="meta_keywords" placeholder="meta-keywords" 
                        value="{{$errorPage->meta_keywords ?? ''}}" required />

                    <label for="path">path</label>
                    <input type="text" class="form-control" id="path" name="path" placeholder="path" 
                        value="{{$errorPage->path ?? ''}}" required disabled />
                    @if(isset($files) && isset($activeScripts))
                        <aditional-js-component 
                            :file-paths="{{json_encode($files)}}" 
                            :db-paths="{{json_encode($activeScripts)}}"
                        >
                        </aditional-js-component>
                    @endif
                    <label for="description">Краткое описание страницы</label>
                    <textarea cols="20" rows="2" id="description" name="description" style="width:100%">
                        {{$errorPage->description ?? ''}}
                    </textarea>

                    <label for="descriptionFull">Полное описание страницы</label>
                    <textarea cols="20" rows="4" id="descriptionFull" name="full_text" style="width:100%">
                        {{$errorPage->full_text ?? ''}}
                    </textarea>

                    <label>
                        <input type="submit" class="btn btn-primary" value="Сохранить" />
                    </label>
                    <input type="hidden" name="modified_by" value="{{Auth::id()}}" />
                </form>
            </div>
        </div>
    </div>
@endsection