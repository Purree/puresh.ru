<div>
    <script src="{{ asset('js/checkBrowserSupport.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if(!isBrowserSupport()) document.querySelector('#BrowserSupportButton').click()
        })
    </script>

    <button type="button" id="BrowserSupportButton" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#browserDoesntSupportModal">
        Launch demo modal
    </button>

    <div class="modal fade" id="browserDoesntSupportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-danger">
                    <h5 class="modal-title" id="exampleModalLabel">Ваш браузер не поддерживается</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Некоторые функции сайта могут работать неверно или не работать вовсе.
                    Для корректной работы рекомендуем скачать последнюю версию вашего браузера
                    Либо <a href="https://www.googleadservices.com/pagead/aclk?sa=L&ai=DChcSEwj0mZji4Jj1AhWLAuYKHUOnALwYABAAGgJscg&ohost=www.google.com&cid=CAASE-RogoiYH08kuTSxtxE3F_Muhus&sig=AOD64_0FKx4YFvz0G_h1fmifK_MbQXbzsA&q&adurl&ved=2ahUKEwjj6pDi4Jj1AhVGxosKHcy4CSEQ0Qx6BAgCEAE"></a> установить Google Chrome.
                </div>
            </div>
        </div>
    </div>
</div>
