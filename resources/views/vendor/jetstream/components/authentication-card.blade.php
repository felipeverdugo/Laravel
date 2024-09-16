<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-vacunasist">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
    <div class="d-flex h-40 align-items-center py-16">
        <div class="mx-auto app-login-box col-md-8">
            <div class="text-center text-black opacity-8">
                    <a class="copyright" href="">&copy; Desarrollado por T°kens S.A.</a>
            </div>
        </div>
    </div>
</div>
