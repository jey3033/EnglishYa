<div id="delete-modal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 opacity-0 transition-opacity duration-300">

    <div class="modal-content bg-card rounded-xl shadow-xl w-full max-w-md
                scale-95 translate-y-4 opacity-0
                transition-all duration-300">

        {{-- Header --}}
        <div class="p-6 text-center">

            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-danger/15 mb-4">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-8 w-8 text-danger">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12" />
                </svg>

            </div>

            <h2 class="modal-title text-2xl font-bold">
                Delete
            </h2>

            <p class="modal-caption mt-3 text-muted">
            </p>

        </div>

        {{-- Footer --}}
        <div class="flex justify-end gap-3 border-t border-border p-4">

            <button
                type="button"
                class="btn btn-secondary close-modal">
                Cancel
            </button>

            <form class="modal-form" method="POST">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-danger">
                    Delete
                </button>

            </form>

        </div>

    </div>

</div>

<script>

$(document).on('click', '.open-delete-modal', function () {

    const button = $(this);

    const modal = $('#delete-modal');

    modal.find('.modal-title')
        .text(`Delete ${button.data('model')}`);

    modal.find('.modal-caption')
        .text(
            `Are you sure you want to delete this ${button.data('model')} "${button.data('name')}"?`
        );

    modal.find('.modal-form')
        .attr('action', button.data('url'));

    modal.removeClass('hidden').addClass('flex');

    const content = modal.find('.modal-content');

    setTimeout(() => {

        modal.removeClass('opacity-0');

        content
            .removeClass('scale-95 translate-y-4 opacity-0')
            .addClass('scale-100 translate-y-0 opacity-100');

    }, 10);

});

$(document).on('click', '.close-modal', function () {

    const modal = $('#delete-modal');

    const content = modal.find('.modal-content');

    content
        .removeClass('scale-100 translate-y-0 opacity-100')
        .addClass('scale-95 translate-y-4 opacity-0');

    modal.addClass('opacity-0');

    setTimeout(() => {

        modal.removeClass('flex').addClass('hidden');

    }, 300);

});

$(document).on('click', '#delete-modal', function(e){

    if(e.target !== this) return;

    const modal = $(this);

    const content = modal.find('.modal-content');

    content
        .removeClass('scale-100 translate-y-0 opacity-100')
        .addClass('scale-95 translate-y-4 opacity-0');

    modal.addClass('opacity-0');

    setTimeout(() => {

        modal.removeClass('flex').addClass('hidden');

    }, 300);

});

</script>