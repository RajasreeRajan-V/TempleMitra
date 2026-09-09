{{-- Delete Confirmation Modal (include this in vazhipad/index.blade.php) --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Vazhipad? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = "{{ url('admin/vazhipad') }}/" + id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>

{{--
Usage in index.blade.php, on each row's delete button:
<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
    <i class="fa fa-trash"></i>
</button>
--}}