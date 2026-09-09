{{-- Temple Vazhipad Delete Confirmation Modal Component --}}
<div class="temple-modal-backdrop" id="templeDeleteModal">
    <div class="temple-modal-card">
        <div class="temple-modal-header">
            <div class="temple-modal-icon-wrap">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </div>
            <div>
                <h4 class="temple-modal-title">Delete Vazhipad</h4>
            </div>
        </div>

        <div class="temple-modal-body">
            Are you sure you want to permanently delete <strong id="deleteOfferingName" class="temple-modal-item-name">this offering</strong>? This action cannot be undone and will remove it from the offering catalogue.
        </div>

        <div class="temple-modal-footer">
            <button type="button" class="btn-temple btn-temple-secondary btn-temple-sm" onclick="closeDeleteModal()">
                Cancel
            </button>

            <form id="templeDeleteForm" method="POST" action="" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-temple btn-temple-danger btn-temple-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    <span>Confirm Delete</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(id, name) {
        const form = document.getElementById('templeDeleteForm');
        form.action = "{{ url('temple/vazhipad') }}/" + id;
        document.getElementById('deleteOfferingName').textContent = '"' + name + '"';
        document.getElementById('templeDeleteModal').classList.add('is-active');
    }

    function closeDeleteModal() {
        document.getElementById('templeDeleteModal').classList.remove('is-active');
    }

    document.getElementById('templeDeleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>