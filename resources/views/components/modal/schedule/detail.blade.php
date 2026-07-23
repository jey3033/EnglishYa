@props([
    'data' => null
])
<div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center opacity-0 transition-opacity duration-300 modal">
    <div class="absolute inset-0 bg-black/50 overlay"></div>
    <div class="modal-content relative bg-primary text-white rounded-lg shadow-xl w-full max-w-lg p-6 scale-95 translate-y-4 opacity-0 transition-all duration-300">
        <h2 class="text-xl font-bold" id="detail-date">
        </h2>
        <div class="mt-4" id="detail-content">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr>
                        <th class="border p-2 w-40">Time</th>
                        <th class="border p-2">Detail</th>
                    </tr>
                </thead>
                <tbody id="meeting-table-body">
                </tbody>
            </table>
        </div>
    </div>
</div>