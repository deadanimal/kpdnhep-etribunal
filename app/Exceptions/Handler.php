<?php

namespace App\Exceptions;

use App\Repositories\TelegramBotRepository;
use Exception;
use GrahamCampbell\Exceptions\ExceptionHandler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Request;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     * @return void
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        $telegram_dont_report = [
            \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Auth\Access\AuthorizationException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
            \Illuminate\Database\Eloquent\ModelNotFoundException::class,
            \Illuminate\Session\TokenMismatchException::class,
            \Illuminate\Validation\ValidationException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class, //404
        ];

        $telegram_dont_report_status = !is_null(array_first($telegram_dont_report, function ($type) use ($exception) {
            return $exception instanceof $type;
        }));

        if (config('app.debug_telegram') && !$telegram_dont_report_status) {
            TelegramBotRepository::send('BUG', $exception->getMessage(), $exception->getFile(),
                $exception->getLine(), url()->previous(), Request::method(), Request::url(), json_encode(Request::all()),
                Request::server('HTTP_USER_AGENT') ?? '-', Request::ip());
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($e instanceof TokenMismatchException) {
            return redirect(route('login', ['token' => 'expired']));
        }

        if ($e instanceof AuthenticationException) {
            return redirect()->guest(route('login'));
        }

        return parent::render($request, $e);
    }

}
