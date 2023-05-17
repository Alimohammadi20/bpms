<div class="col-lg-3 col-md-6">
    <div class="mt-3">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd"
             aria-labelledby="offcanvasEndLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasEndLabel" class="offcanvas-title">جزییات وظیفه</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>

            <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                <div class="row">
                    <div class=" task-detail-sidebar">
                        <strong>شناسه :</strong>
                        <p>{{session('openedTask')->id}}</p>
                    </div>
                    <div class=" task-detail-sidebar">
                        <strong>عنوان فرایند :</strong>
                        <p>{{session('openedTask')->processName}}</p>
                    </div>
                    <div class=" task-detail-sidebar">
                        <strong>شناسه فرایند :</strong>
                        <p>{{session('openedTask')->processInstanceId}}</p>
                    </div>
                    <div class=" task-detail-sidebar">
                        <strong>تاریخ ایجاد :</strong>
                        <p>{{session('openedTask')->createTime}}</p>
                    </div>
                    <div class=" task-detail-sidebar">
                        <strong>فرایند اجرا شده :</strong>
                        <p>{{session('openedTask')->processDefinitionId}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
