<?php

namespace Webdev\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Webdev\Models\BlogwdErrorPage;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            //Create page name like: errors/404.blade.php
            $pageName = strval($exception->getStatusCode());
            //Concat page name with folder 'errors'
            $view = "errors.{$pageName}";
            //Check if View exists
            if(view()->exists($view)) {
                //Get the page data
                $page = BlogwdErrorPage::isPublished()->where("path",$pageName)->first();
                //Styles by default
                $styles = [];
                //Sort all the bound CSS files for this page
                foreach($page->styles as $style){
                    $styles[] = $style->path_css;
                }
                //Scripts by default
                $scripts = [];
                //Sorts all the bound files and put them in two arrays 'header' and 'footer'
                foreach($page->scripts as $script){
                    if($script->header_or_footer == 0){
                        $scripts['header'][] = $script->path_js;
                    }else{
                        $scripts['footer'][] = $script->path_js;
                    }
                }
                if(!is_null($page)){
                    //Return data
                    return response()->view($view, [
                        'title'=>$page->title,
                        'meta_description'=>$page->meta_description,
                        'meta_keywords'=>$page->meta_keywords,
                        'description'=>$page->description,
                        'full_text'=>$page->full_text,
                        'status'=>$exception->getStatusCode(),
                        'exception' => $exception,
                        'styles' => $styles,
                        'scripts' => $scripts
                    ], $exception->getStatusCode());
                }else{
                    return parent::render($request, $exception);
                }
            }
        }

        return parent::render($request, $exception);
    }
}
