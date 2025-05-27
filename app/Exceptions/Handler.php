<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Handle specific exceptions like 403 and 419.
     */
    public function render($request, Throwable $exception)
    {
        // Si el usuario no tiene permiso (403), cerramos sesión y redirigimos
        if ($exception instanceof AuthorizationException) {
            Auth::logout();
            return redirect()->route('logout');
        }

        // Si la sesión expira (419), cerramos sesión y redirigimos
        if ($exception instanceof HttpException && $exception->getStatusCode() === 419) {
            Auth::logout();
            return redirect()->route('logout');
        }

        return parent::render($request, $exception);
    }
}
