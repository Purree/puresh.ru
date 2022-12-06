<div>
    <x-integrations.vk/>

    <div class="d-flex justify-content-center flex-column">
        <div class="mb-3">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info mt-3 w-100 text-white" data-bs-toggle="collapse"
                            data-bs-target="#showVKDataCollapse" aria-expanded="false"
                            aria-controls="showVKDataCollapse">
                        {{ __('Profile Information') }}
                    </button>
                </div>
                <div class="collapse card-body" id="showVKDataCollapse">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <img width="70px" height="70px" class="rounded-circle cursor-pointer"
                                 onclick="window.open('https://vk.com', '_blank').focus()"
                                 src="https://vk.com/images/camera_200.png" alt="vk profile avatar"/>
                        </div>
                        <div>
                            <h5 class="card-title">Name nickname Surname</h5>
                            <a class="link" href="https://vk.com/screen_name">https://vk.com/screen_name</a>
                            <div>ID: 656830713</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
