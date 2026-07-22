@props([
    'data' => null
])
<div id="confirmation-modal" class="fixed inset-0 z-50 hidden items-center justify-center opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/50 overlay"></div>
    <div class="modal-content relative bg-primary-light text-white rounded-lg shadow-xl w-full max-w-lg p-6 scale-95 translate-y-4 opacity-0 transition-all duration-300">
        <h2 class="text-xl font-bold" id="confirmation-date">
            Teacher Availability
        </h2>
        <div class="mt-4" id="confirmation-content">
            <p>
                Are you sure you want to make yourself available
                for class on
            </p>
            <strong>
                24 July 2026
            </strong>
            <br>
            <strong>
                09:00 - 10:00
            </strong>
            <div class="flex justify-end gap-3 mt-5">
                <button class="btn btn-muted" id="cancel-modal">
                    Cancel
                </button>
                <button class="btn btn-primary" id="confirm-availability">
                    Yes
                </button>
            </div>
        </div>
    </div>
</div>