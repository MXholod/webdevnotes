<?php

namespace Webdev\Exceptions;

use Exception;
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
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
                    ], $exception->getStatusCode());
                }else{
                    return parent::render($request, $exception);
                }
            }
        }

        return parent::render($request, $exception);
    }
}
