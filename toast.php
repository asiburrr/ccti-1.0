    <!-- Toast Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11;">
        <?php if (!empty($_SESSION['successMessages'])) : ?>
            <?php foreach ($_SESSION['successMessages'] as $successMessage) : ?>
                <div class="toast bg-success text-white animate__animated animate__fadeInRight" role="alert" style="            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);">
                    <div class="toast-header bg-success text-white" style="            border-radius: 10px 10px 0 0;">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        <?= $successMessage ?>
                    </div>
                    <div class="progress" style="            height: 5px;
            margin: 0;
            border-radius: 0 0 10px 10px;
            background-color: #ffffff;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['successMessages']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['errorMessages'])) : ?>
            <?php foreach ($_SESSION['errorMessages'] as $errorMessage) : ?>
                <div class="toast bg-danger text-white animate__animated animate__fadeInRight" style="            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);" role="alert">
                    <div class="toast-header bg-danger text-white" style="            border-radius: 10px 10px 0 0;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong class="me-auto">Error</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        <?= $errorMessage ?>
                    </div>
                    <div class="progress" style="            height: 5px;
            margin: 0;
            border-radius: 0 0 10px 10px;
            background-color: #ffffff;">
                        <div class="progress-bar bg-danger" role="progressbar " style="width: 100%;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['errorMessages']); ?>
        <?php endif; ?>
    </div>
    <script>
        // Show Toasts
        document.querySelectorAll('.toast').forEach(toastEl => {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
        document.querySelectorAll('.toast').forEach(toastEl => {
            const toast = new bootstrap.Toast(toastEl);
            const progressBar = toastEl.querySelector('.progress-bar');
            let width = 100;
            const duration = 5000;
            const interval = 50;
            const decrement = (interval / duration) * 100;

            toast.show();

            const intervalId = setInterval(() => {
                width -= decrement;
                if (width <= 0) {
                    width = 0;
                    clearInterval(intervalId);
                }
                progressBar.style.width = `${width}%`;
                progressBar.setAttribute('aria-valuenow', Math.round(width));
            }, interval);

            toastEl.addEventListener('hidden.bs.toast', () => clearInterval(intervalId));
        });
    </script>